import datetime
from typing import Any
from django.db.models.query import QuerySet
from django.contrib.auth.mixins import LoginRequiredMixin
from django.shortcuts import redirect, render
from django.views import View
from .models import Piloto, Pais, Escuderia, Circuito, Carrera, Usuario
from django.urls import reverse_lazy
from django.db.models import Sum

from django.views.generic import (
    ListView,
    DetailView,
    DeleteView,
    UpdateView,
    CreateView,
)

# Menú de Admin

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

def carreraAdmin(request):
    return render(request, "mundialitopx/admin/carrera.html", {})

# CRUD Pais
class DetallesPais(DetailView):
    model = Pais
    template_name = "mundialitopx/admin/CRUD/detalle.html"

class BorrarPais(DeleteView):
    model = Pais
    template_name = "mundialitopx/admin/CRUD/borrar.html"
    success_url = reverse_lazy("admin")

class EditarPais(UpdateView):
    model = Pais
    fields = ['nombre', 'bandera']
    template_name = "mundialitopx/admin/CRUD/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearPais(CreateView):
    model = Pais
    fields = ['nombre', 'bandera']
    template_name = "mundialitopx/admin/CRUD/crear.html"
    success_url = reverse_lazy("admin")

# CRUD Escuderia
class DetallesEscuderia(DetailView):
    model = Escuderia
    template_name = "mundialitopx/admin/CRUD/detalle.html"

class BorrarEscuderia(DeleteView):
    model = Escuderia
    template_name = "mundialitopx/admin/CRUD/borrar.html"
    success_url = reverse_lazy("admin")

class EditarEscuderia(UpdateView):
    model = Escuderia
    fields = ['nombre', 'alias', 'monoplaza', 'pais', 'logo', 'puesto', 'descripcion']
    template_name = "mundialitopx/admin/CRUD/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearEscuderia(CreateView):
    model = Escuderia
    fields = ['nombre', 'alias', 'monoplaza', 'pais', 'logo', 'puesto', 'descripcion']
    template_name = "mundialitopx/admin/CRUD/crear.html"
    success_url = reverse_lazy("admin")

# CRUD Piloto
class DetallesPiloto(DetailView):
    model = Piloto
    template_name = "mundialitopx/admin/CRUD/detalle.html"

class BorrarPiloto(DeleteView):
    model = Piloto
    template_name = "mundialitopx/admin/CRUD/borrar.html"
    success_url = reverse_lazy("admin")

class EditarPiloto(UpdateView):
    model = Piloto
    fields = ['nombre', 'dorsal', 'escuderia', 'pais', 'foto', 'puesto', 'biografia']
    template_name = "mundialitopx/admin/CRUD/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearPiloto(CreateView):
    model = Piloto
    fields = ['nombre', 'dorsal', 'escuderia', 'pais', 'foto', 'puesto', 'biografia']
    template_name = "mundialitopx/admin/CRUD/crear.html"
    success_url = reverse_lazy("admin")


# CRUD Circuito
class DetallesCircuito(DetailView):
    model = Circuito
    template_name = "mundialitopx/admin/CRUD/detalle.html"

class BorrarCircuito(DeleteView):
    model = Circuito
    template_name = "mundialitopx/admin/CRUD/borrar.html"
    success_url = reverse_lazy("admin")

class EditarCircuito(UpdateView):
    model = Circuito
    fields = ['nombre', 'alias', 'pista', 'pais']
    template_name = "mundialitopx/admin/CRUD/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearCircuito(CreateView):
    model = Circuito
    fields = ['nombre', 'alias', 'pista', 'pais']
    template_name = "mundialitopx/admin/CRUD/crear.html"
    success_url = reverse_lazy("admin")


# CRUD Carrera
class DetallesCarrera(DetailView):
    model = Carrera
    template_name = "mundialitopx/admin/CRUD/detalle.html"

class BorrarCarrera(DeleteView):
    model = Carrera
    template_name = "mundialitopx/admin/CRUD/borrar.html"
    success_url = reverse_lazy("admin")

