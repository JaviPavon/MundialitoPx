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


