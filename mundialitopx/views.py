import datetime
from typing import Any, Dict  # Importa Dict desde typing
from django.db.models.query import QuerySet
from django.contrib.auth.mixins import LoginRequiredMixin
from django.http import HttpRequest, HttpResponse
from django.shortcuts import get_object_or_404, redirect, render
from django.views import View
from .models import Piloto, Pais, Escuderia, Circuito, Carrera, Usuario, Noticia, Liga, PilotoJuego, Jugador, Comentario
from django.urls import reverse_lazy
from django.db.models import Sum
from .forms import CarreraForm, RegisterForm, NoticiaForm, LigaForm,ComentarioForm

from django.views.generic import (
    ListView,
    DetailView,
    DeleteView,
    UpdateView,
    CreateView,
)


# region Fantasy


class CrearLiga(LoginRequiredMixin, CreateView):
    template_name = "mundialitopx/main/fantasy/crear_liga.html"
    form_class = LigaForm
    success_url = reverse_lazy("fantasy")

    def form_valid(self, form):
        liga = form.save(commit=False)
        liga.save()
        liga.usuarios.add(self.request.user)

        Jugador.objects.create(
            usuario=self.request.user,
            liga=liga,
            saldo=1500000  
        )

        return super().form_valid(form)

class ListaLigas(LoginRequiredMixin, ListView):
    model = Jugador
    template_name = 'mundialitopx/main/fantasy/fantasy.html'
    context_object_name = 'ligas'
    
    def get_queryset(self):
        return Jugador.objects.filter(usuario=self.request.user)

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)

        context["pilotos"] = PilotoJuego.objects.all().order_by("piloto__escuderia")

        return context

class ListaLigasDisponibles(LoginRequiredMixin, ListView):
    model = Liga
    template_name = 'mundialitopx/main/fantasy/unirse_liga.html'
    context_object_name = 'ligas'

    def get_queryset(self):
        usuario_actual = self.request.user
        return Liga.objects.filter(estado='Publico').exclude(usuarios=usuario_actual)

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        usuario_actual = self.request.user
        context["ligaspriv"] = Liga.objects.filter(estado='Privado').exclude(usuarios=usuario_actual)
        return context

class DetalleLiga(LoginRequiredMixin, DetailView):
    model = Liga
    template_name = 'mundialitopx/main/fantasy/liga.html'
    context_object_name = 'liga'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        liga_id = self.kwargs['pk']

        context['clasificacion_jugadores'] = Jugador.objects.filter(liga_id=liga_id).order_by('-puntos_totales')

        usuario_actual = self.request.user
        jugador_actual = Jugador.objects.get(usuario=usuario_actual, liga_id=liga_id)
        pilotos_juego_jugador_actual = jugador_actual.piloto.all()
        context['pilotos_juego_jugador_actual'] = pilotos_juego_jugador_actual

        context['pilotos'] = PilotoJuego.objects.exclude(id__in=pilotos_juego_jugador_actual.values_list('id', flat=True))

        return context


class SeleccionarPiloto(LoginRequiredMixin, CreateView):
    model = PilotoJuego
    template_name = 'mundialitopx/main/fantasy/seleccionar_jugador.html'
    fields = []

    def get(self, request, pk):
        self.piloto_pk = pk
        return super().get(request)

    def form_valid(self, form, pk):
        jugador = Jugador.objects.filter(usuario=self.request.user)
        piloto = PilotoJuego.objects.filter(pk=pk)

        if jugador.saldo >= piloto.valor:

            jugador.saldo -= piloto.valor
            jugador.save()

            jugador.piloto.add(piloto)

            return super().form_valid(form)
        else:
            return redirect('liga_jugador')
# endregion

# region Página Principal

def home(request):
    return render(request, "mundialitopx/main/home.html", {})

class ListaNoticias(ListView):
    model = Noticia
    template_name = "mundialitopx/main/noticias/noticias.html"
    context_object_name = "noticias"

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)

        context["noticias"] = Noticia.objects.all()
        context["circuitos"] = Circuito.objects.all().order_by("fecha")

        return context


class ListaPilotos(ListView):
    model = Piloto
    template_name = "mundialitopx/main/pilotos/pilotos.html"
    context_object_name = "pilotos"

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)

        context["pilotos"] = Piloto.objects.all().order_by("escuderia")
        context["pilotosc"] = Piloto.objects.all().order_by("puesto")

        return context


class DetallePiloto(DetailView):
    model = Piloto
    template_name = "mundialitopx/main/pilotos/detalle_piloto.html"

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)
        piloto = self.object
        context["carreras"] = Carrera.objects.filter(piloto=piloto)
        return context


class DetalleEscuderia(DetailView):
    model = Escuderia
    template_name = "mundialitopx/main/escuderias/detalle_escuderia.html"

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)
        escuderia = self.object
        context["carreras"] = Carrera.objects.filter(piloto__escuderia=escuderia)
        context["carreras"] = context["carreras"].order_by("circuito")
        context["pilotos"] = Piloto.objects.filter(escuderia=escuderia)
        return context


class DetalleNoticia(DetailView):
    model = Noticia
    template_name = "mundialitopx/main/noticias/detalle_noticia.html"

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        noticia = self.get_object()

        context['comentarios'] = Comentario.objects.filter(noticia=noticia)

        return context

class CrearNoticia(CreateView):
    template_name = "mundialitopx/main/noticias/crear_noticia.html"
    form_class = NoticiaForm

    def form_valid(self, form):
        noticia = form.save(commit=False)
        noticia.autor = self.request.user
        noticia.fecha_publicacion = datetime.datetime.now().strftime("%Y-%m-%d")
        noticia.save()
        form.save_m2m()
        return redirect("noticias")

class CrearComentario(CreateView):
    template_name = "mundialitopx/main/noticias/crear_comentario.html"
    form_class = ComentarioForm

    def form_valid(self, form):
        noticia_id = self.kwargs['noticia_id']
        noticia = Noticia.objects.get(pk=noticia_id)

        comentario = form.save(commit=False)
        comentario.autor = self.request.user
        comentario.noticia = noticia
        comentario.fecha_publicacion = datetime.datetime.now().strftime("%Y-%m-%d")
        comentario.save()
        return redirect("noticias")


class ListaEscuderias(ListView):
    model = Escuderia
    template_name = "mundialitopx/main/escuderias/escuderias.html"
    context_object_name = "escuderias"

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)

        context["escuderias"] = Escuderia.objects.all().order_by("-puntos")

        return context


# endregion

# region Menú de Admin


def register(request):
    if request.method == "POST":
        form = RegisterForm(request.POST)
        if form.is_valid():
            form.save()
        return redirect("inicio")
    else:
        form = RegisterForm()
        return render(request, "registration/registrar.html", {"form": form})


def admin(request):
    return render(request, "mundialitopx/admin/admin.html", {})


class ListPaises(LoginRequiredMixin, ListView):
    model = Pais
    template_name = "mundialitopx/admin/pais.html"
    context_object_name = "paises"


class ListPilotos(LoginRequiredMixin, ListView):
    model = Piloto
    template_name = "mundialitopx/admin/piloto.html"
    context_object_name = "pilotos"


class ListEscuderias(LoginRequiredMixin, ListView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderia.html"
    context_object_name = "escuderias"


class ListCircuitos(LoginRequiredMixin, ListView):
    model = Circuito
    template_name = "mundialitopx/admin/circuito.html"
    context_object_name = "circuitos"


class ListCarreras(LoginRequiredMixin, ListView):
    model = Carrera
    template_name = "mundialitopx/admin/carrera.html"

    def get_context_data(self, **kwargs: Any) -> Dict[str, Any]:  # Cambia la anotación de tipo aquí
        context = super().get_context_data(**kwargs)
        piloto = self.request.GET.get("piloto")
        circuito = self.request.GET.get("circuito")

        context["circuitos"] = Circuito.objects.all()
        context["carreras"] = Carrera.objects.all()
        if piloto != "todo" and piloto is not None:
            context["carreras"] = context["carreras"].filter(
                piloto__nombre__contains=piloto
            )
        if circuito != "todo" and circuito is not None:
            context["carreras"] = context["carreras"].filter(circuito=circuito)
        return context


# endregion
# region CRUD Pais
class DetallesPais(LoginRequiredMixin, DetailView):
    model = Pais
    template_name = "mundialitopx/admin/paises/detalle.html"


class BorrarPais(LoginRequiredMixin, DeleteView):
    model = Pais
    template_name = "mundialitopx/admin/paises/borrar.html"
    success_url = reverse_lazy("admin")


class EditarPais(LoginRequiredMixin, UpdateView):
    model = Pais
    fields = ["nombre", "bandera"]
    template_name = "mundialitopx/admin/paises/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearPais(LoginRequiredMixin, CreateView):
    model = Pais
    fields = ["nombre", "bandera"]
    template_name = "mundialitopx/admin/paises/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Escuderia
class DetallesEscuderia(LoginRequiredMixin, DetailView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderias/detalle.html"


class BorrarEscuderia(LoginRequiredMixin, DeleteView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderias/borrar.html"
    success_url = reverse_lazy("admin")


class EditarEscuderia(LoginRequiredMixin, UpdateView):
    model = Escuderia
    fields = ["nombre", "alias", "monoplaza", "pais", "logo", "puesto", "descripcion"]
    template_name = "mundialitopx/admin/escuderias/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearEscuderia(LoginRequiredMixin, CreateView):
    model = Escuderia
    fields = ["nombre", "alias", "monoplaza", "pais", "logo", "puesto", "descripcion"]
    template_name = "mundialitopx/admin/escuderias/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Piloto
class DetallesPiloto(LoginRequiredMixin, DetailView):
    model = Piloto
    template_name = "mundialitopx/admin/pilotos/detalle.html"


class BorrarPiloto(LoginRequiredMixin, DeleteView):
    model = Piloto
    template_name = "mundialitopx/admin/pilotos/borrar.html"
    success_url = reverse_lazy("admin")


class EditarPiloto(LoginRequiredMixin, UpdateView):
    model = Piloto
    fields = ["nombre", "dorsal", "escuderia", "pais", "foto", "puesto", "biografia"]
    template_name = "mundialitopx/admin/pilotos/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearPiloto(LoginRequiredMixin, CreateView):
    model = Piloto
    fields = ["nombre", "dorsal", "escuderia", "pais", "foto", "puesto", "biografia"]
    template_name = "mundialitopx/admin/pilotos/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Circuito
class DetallesCircuito(LoginRequiredMixin, DetailView):
    model = Circuito
    template_name = "mundialitopx/admin/circuitos/detalle.html"


class BorrarCircuito(LoginRequiredMixin, DeleteView):
    model = Circuito
    template_name = "mundialitopx/admin/circuitos/borrar.html"
    success_url = reverse_lazy("admin")


class EditarCircuito(LoginRequiredMixin, UpdateView):
    model = Circuito
    fields = ["nombre", "alias", "pista", "pais","silueta"]
    template_name = "mundialitopx/admin/circuitos/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearCircuito(LoginRequiredMixin, CreateView):
    model = Circuito
    fields = ["nombre", "alias", "pista", "pais","silueta"]
    template_name = "mundialitopx/admin/circuitos/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Carrera
class DetallesCarrera(LoginRequiredMixin, DetailView):
    model = Carrera
    template_name = "mundialitopx/admin/carreras/detalle.html"


class BorrarCarrera(LoginRequiredMixin, DeleteView):
    model = Carrera
    template_name = "mundialitopx/admin/carreras/borrar.html"
    success_url = reverse_lazy("admin")

    def post(self, request, pk):
        carrera = Carrera.objects.get(pk=pk)
        piloto = carrera.piloto
        escuderia = piloto.escuderia

        piloto.puntos -= carrera.puntos
        piloto.save()
        piloto.actualizar_puesto()

        escuderia.puntos -= carrera.puntos
        escuderia.save()
        escuderia.actualizar_puesto()

        carrera.delete()

        return redirect("carrera")


class CrearCarrera(LoginRequiredMixin, CreateView):
    nombre_template = "mundialitopx/admin/carreras/crear.html"

    def get(self, request):
        form = CarreraForm()
        pilotos = Piloto.objects.all()
        circuitos = Circuito.objects.all()
        return render(
            request,
            self.nombre_template,
            {"form": form, "circuitos": circuitos, "pilotos": pilotos},
        )

    def post(self, request):
        form = CarreraForm(request.POST)
        if form.is_valid():
            puesto = form.cleaned_data["puesto"]
            pilotoform = form.cleaned_data["piloto"]
            circuito = form.cleaned_data["circuito"]
            vuelta_rapida = form.cleaned_data["vuelta_rapida"]
            piloto = Piloto.objects.get(nombre=pilotoform)
            escuderia = piloto.escuderia
            carrera = form.save(commit=False)
            if puesto == 1:
                puntos = 25
            elif puesto == 2:
                puntos = 18
            elif puesto == 3:
                puntos = 15
            elif puesto == 4:
                puntos = 10
            elif puesto == 5:
                puntos = 8
            elif puesto == 6:
                puntos = 6
            elif puesto == 7:
                puntos = 5
            elif puesto == 8:
                puntos = 3
            elif puesto == 9:
                puntos = 2
            elif puesto == 10:
                puntos = 1
            else:
                puntos = 0

            if vuelta_rapida:
                puntos += 1

            carrera.puesto = puesto
            carrera.puntos = puntos
            carrera.piloto = pilotoform
            carrera.circuito = circuito
            carrera.save()

            piloto.puntos += puntos
            piloto.save()
            piloto.actualizar_puesto()

            escuderia.puntos += puntos
            escuderia.save()
            escuderia.actualizar_puesto()

        return redirect("carrera")


class EditarCarrera(LoginRequiredMixin, UpdateView):
    model = Carrera
    fields = ["piloto", "circuito", "puesto", "estado", "vuelta_rapida"]
    template_name = "mundialitopx/admin/carreras/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")

    def post(self, request, pk):
        puntos = 0
        vuelta_rapida = request.POST.get("vuelta_rapida")
        puesto = int(request.POST.get("puesto"))
        carrera = Carrera.objects.get(pk=pk)
        piloto = carrera.piloto
        escuderia = piloto.escuderia

        if puesto == 1:
            puntos = 25
        elif puesto == 2:
            puntos = 18
        elif puesto == 3:
            puntos = 15
        elif puesto == 4:
            puntos = 10
        elif puesto == 5:
            puntos = 8
        elif puesto == 6:
            puntos = 6
        elif puesto == 7:
            puntos = 5
        elif puesto == 8:
            puntos = 3
        elif puesto == 9:
            puntos = 2
        elif puesto == 10:
            puntos = 1
        else:
            puntos = 0

        if vuelta_rapida:
            puntos += 1

        piloto.puntos -= carrera.puntos
        piloto.puntos += puntos
        piloto.save()
        piloto.actualizar_puesto()

        escuderia.puntos -= carrera.puntos
        escuderia.puntos += puntos
        escuderia.save()
        escuderia.actualizar_puesto()

        carrera.puesto = puesto
        carrera.puntos = puntos
        if vuelta_rapida:
            carrera.vuelta_rapida = True
        else:
            carrera.vuelta_rapida = False
        carrera.save()

        return redirect("carrera")


# endregion