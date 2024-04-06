import datetime
from typing import Any
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



# region Página Principal

def home(request):
    return render(request, "mundialitopx/main/home.html", {})

class ListaNoticias(ListView):
    model = Noticia
    template_name = "mundialitopx/main/noticias/noticias.html"
    context_object_name = "noticias"

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
        context = super().get_context_data(**kwargs)

        context["noticias"] = Noticia.objects.all()
        context["circuitos"] = Circuito.objects.all().order_by("fecha")

        return context


class ListaPilotos(ListView):
    model = Piloto
    template_name = "mundialitopx/main/pilotos/pilotos.html"
    context_object_name = "pilotos"

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
        context = super().get_context_data(**kwargs)

        context["pilotos"] = Piloto.objects.all().order_by("escuderia")
        context["pilotosc"] = Piloto.objects.all().order_by("puesto")

        return context


class DetallePiloto(DetailView):
    model = Piloto
    template_name = "mundialitopx/main/pilotos/detalle_piloto.html"

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
        context = super().get_context_data(**kwargs)
        piloto = self.object
        context["carreras"] = Carrera.objects.filter(piloto=piloto)
        return context


class DetalleEscuderia(DetailView):
    model = Escuderia
    template_name = "mundialitopx/main/escuderias/detalle_escuderia.html"

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
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

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
        context = super().get_context_data(**kwargs)

        context["escuderias"] = Escuderia.objects.all().order_by("-puntos")

        return context


# endregion

# region Menú de Admin


def register(response):
    if response.method == "POST":
        form = RegisterForm(response.POST)
        if form.is_valid():
            form.save()
        return redirect("inicio")
    else:
        form = RegisterForm()
        return render(response, "registration/registrar.html", {"form": form})


def admin(request):
    return render(request, "mundialitopx/admin/admin.html", {})


class ListPaises(ListView):
    model = Pais
    template_name = "mundialitopx/admin/pais.html"
    context_object_name = "paises"


class ListPilotos(ListView):
    model = Piloto
    template_name = "mundialitopx/admin/piloto.html"
    context_object_name = "pilotos"


class ListEscuderias(ListView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderia.html"
    context_object_name = "escuderias"


class ListCircuitos(ListView):
    model = Circuito
    template_name = "mundialitopx/admin/circuito.html"
    context_object_name = "circuitos"


class ListCarreras(ListView):
    model = Carrera
    template_name = "mundialitopx/admin/carrera.html"

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
        context = super().get_context_data(**kwargs)
        piloto = self.request.GET.get("piloto")
        circuito = self.request.GET.get("circuito")

        context["circuitos"] = Circuito.objects.all()
        context["carreras"] = Carrera.objects.all()
        if piloto != "todo" and piloto != None:
            context["carreras"] = context["carreras"].filter(
                piloto__nombre__contains=piloto
            )
        if circuito != "todo" and circuito != None:
            context["carreras"] = context["carreras"].filter(circuito=circuito)
        return context


# endregion
# region CRUD Pais
class DetallesPais(DetailView):
    model = Pais
    template_name = "mundialitopx/admin/paises/detalle.html"


class BorrarPais(DeleteView):
    model = Pais
    template_name = "mundialitopx/admin/paises/borrar.html"
    success_url = reverse_lazy("admin")


class EditarPais(UpdateView):
    model = Pais
    fields = ["nombre", "bandera"]
    template_name = "mundialitopx/admin/paises/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearPais(CreateView):
    model = Pais
    fields = ["nombre", "bandera"]
    template_name = "mundialitopx/admin/paises/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Escuderia
class DetallesEscuderia(DetailView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderias/detalle.html"


class BorrarEscuderia(DeleteView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderias/borrar.html"
    success_url = reverse_lazy("admin")


class EditarEscuderia(UpdateView):
    model = Escuderia
    fields = ["nombre", "alias", "monoplaza", "pais", "logo", "puesto", "descripcion"]
    template_name = "mundialitopx/admin/escuderias/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearEscuderia(CreateView):
    model = Escuderia
    fields = ["nombre", "alias", "monoplaza", "pais", "logo", "puesto", "descripcion"]
    template_name = "mundialitopx/admin/escuderias/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Piloto
class DetallesPiloto(DetailView):
    model = Piloto
    template_name = "mundialitopx/admin/pilotos/detalle.html"


class BorrarPiloto(DeleteView):
    model = Piloto
    template_name = "mundialitopx/admin/pilotos/borrar.html"
    success_url = reverse_lazy("admin")


class EditarPiloto(UpdateView):
    model = Piloto
    fields = ["nombre", "dorsal", "escuderia", "pais", "foto", "puesto", "biografia"]
    template_name = "mundialitopx/admin/pilotos/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearPiloto(CreateView):
    model = Piloto
    fields = ["nombre", "dorsal", "escuderia", "pais", "foto", "puesto", "biografia"]
    template_name = "mundialitopx/admin/pilotos/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Circuito
class DetallesCircuito(DetailView):
    model = Circuito
    template_name = "mundialitopx/admin/circuitos/detalle.html"


class BorrarCircuito(DeleteView):
    model = Circuito
    template_name = "mundialitopx/admin/circuitos/borrar.html"
    success_url = reverse_lazy("admin")


class EditarCircuito(UpdateView):
    model = Circuito
    fields = ["nombre", "alias", "pista", "pais","silueta"]
    template_name = "mundialitopx/admin/circuitos/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")


class CrearCircuito(CreateView):
    model = Circuito
    fields = ["nombre", "alias", "pista", "pais","silueta"]
    template_name = "mundialitopx/admin/circuitos/crear.html"
    success_url = reverse_lazy("admin")


# endregion
# region CRUD Carrera
class DetallesCarrera(DetailView):
    model = Carrera
    template_name = "mundialitopx/admin/carreras/detalle.html"


class BorrarCarrera(DeleteView):
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


class CrearCarrera(CreateView):
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


class EditarCarrera(UpdateView):
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
