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



from django.shortcuts import render, redirect
from django.views.generic import ListView, DetailView, CreateView, UpdateView, DeleteView
from django.urls import reverse_lazy
from .models import Noticia, Piloto, Escuderia, Circuito, Carrera, Pais, Comentario
from .forms import NoticiaForm, ComentarioForm, CarreraForm, RegisterForm

# region Página Principal

def home(request):
    return render(request, "mundialitopx/main/home.html", {})

class ListaNoticias(ListView):
    model = Noticia
    template_name = "mundialitopx/main/noticias/noticias.html"
    context_object_name = "noticias"

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["noticias"] = Noticia.objects.all()
        context["circuitos"] = Circuito.objects.all().order_by("fecha")
        return context

class ListaPilotos(ListView):
    model = Piloto
    template_name = "mundialitopx/main/pilotos/pilotos.html"
    context_object_name = "pilotos"

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["pilotos"] = Piloto.objects.all().order_by("escuderia")
        context["pilotosc"] = Piloto.objects.all().order_by("puesto")
        return context

class DetallePiloto(DetailView):
    model = Piloto
    template_name = "mundialitopx/main/pilotos/detalle_piloto.html"

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        piloto = self.object
        context["carreras"] = Carrera.objects.filter(piloto=piloto)
        return context

class DetalleEscuderia(DetailView):
    model = Escuderia
    template_name = "mundialitopx/main/escuderias/detalle_escuderia.html"

    def get_context_data(self, **kwargs):
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
        noticia = self.object
        context['comentarios'] = Comentario.objects.filter(noticia=noticia)
        return context

class CrearNoticia(CreateView):
    template_name = "mundialitopx/main/noticias/crear_noticia.html"
    form_class = NoticiaForm
    success_url = reverse_lazy("noticias")

    def form_valid(self, form):
        noticia = form.save(commit=False)
        noticia.autor = self.request.user
        noticia.fecha_publicacion = datetime.datetime.now().strftime("%Y-%m-%d")
        noticia.save()
        form.save_m2m()
        return super().form_valid(form)

class CrearComentario(CreateView):
    template_name = "mundialitopx/main/noticias/crear_comentario.html"
    form_class = ComentarioForm
    success_url = reverse_lazy("noticias")

    def form_valid(self, form):
        noticia_id = self.kwargs['noticia_id']
        noticia = Noticia.objects.get(pk=noticia_id)
        comentario = form.save(commit=False)
        comentario.autor = self.request.user
        comentario.noticia = noticia
        comentario.fecha_publicacion = datetime.datetime.now().strftime("%Y-%m-%d")
        comentario.save()
        return super().form_valid(form)

class ListaEscuderias(ListView):
    model = Escuderia
    template_name = "mundialitopx/main/escuderias/escuderias.html"
    context_object_name = "escuderias"

    def get_context_data(self, **kwargs):
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

    def get_context_data(self, **kwargs):
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
    model = Carrera
    form_class = CarreraForm
    template_name = "mundialitopx/admin/carreras/crear.html"
    success_url = reverse_lazy("admin")

    def form_valid(self, form):
        carrera = form.save(commit=False)
        piloto = carrera.piloto
        escuderia = piloto.escuderia
        puntos = carrera.calcular_puntos()
        carrera.puntos = puntos
        carrera.save()
        piloto.puntos += puntos
        piloto.save()
        piloto.actualizar_puesto()
        escuderia.puntos += puntos
        escuderia.save()
        escuderia.actualizar_puesto()
        return super().form_valid(form)

class EditarCarrera(UpdateView):
    model = Carrera
    form_class = CarreraForm
    template_name = "mundialitopx/admin/carreras/editar.html"
    success_url = reverse_lazy("admin")

    def form_valid(self, form):
        carrera = form.save(commit=False)
        piloto = carrera.piloto
        escuderia = piloto.escuderia
        puntos = carrera.calcular_puntos()
        piloto.puntos -= carrera.puntos
        piloto.puntos += puntos
        piloto.save()
        piloto.actualizar_puesto()
        escuderia.puntos -= carrera.puntos
        escuderia.puntos += puntos
        escuderia.save()
        escuderia.actualizar_puesto()
        carrera.puntos = puntos
        return super().form_valid(form)

# endregion