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

def pilotoAdmin(request):
    return render(request, "mundialitopx/admin/piloto.html", {})

def paisAdmin(request):
    return render(request, "mundialitopx/admin/pais.html", {})

def escuderiaAdmin(request):
    return render(request, "mundialitopx/admin/escuderia.html", {})

def circuitoAdmin(request):
    return render(request, "mundialitopx/admin/circuito.html", {})

def carreraAdmin(request):
    return render(request, "mundialitopx/admin/carrera.html", {})

# CRUD Pais
class DetallesPais(DetailView):
    model = Pais
    template_name = "mundialitopx/admin/paises/detalle.html"

class BorrarPais(DeleteView):
    model = Pais
    template_name = "mundialitopx/admin/paises/borrar.html"
    success_url = reverse_lazy("admin")

class EditarPais(UpdateView):
    model = Pais
    fields = ['nombre', 'bandera']
    template_name = "mundialitopx/admin/paises/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearPais(CreateView):
    model = Pais
    fields = ['nombre', 'bandera']
    template_name = "mundialitopx/admin/paises/crear.html"
    success_url = reverse_lazy("admin")

# CRUD Escuderia
class DetallesEscuderia(DetailView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderias/detalle.html"

class BorrarEscuderia(DeleteView):
    model = Escuderia
    template_name = "mundialitopx/admin/escuderias/borrar.html"
    success_url = reverse_lazy("admin")

class EditarEscuderia(UpdateView):
    model = Escuderia
    fields = ['nombre', 'alias', 'monoplaza', 'pais', 'logo', 'puesto', 'descripcion']
    template_name = "mundialitopx/admin/escuderias/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearEscuderia(CreateView):
    model = Escuderia
    fields = ['nombre', 'alias', 'monoplaza', 'pais', 'logo', 'puesto', 'descripcion']
    template_name = "mundialitopx/admin/escuderias/crear.html"
    success_url = reverse_lazy("admin")



