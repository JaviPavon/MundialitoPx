import datetime
from typing import Any
from django.db.models.query import QuerySet
from django.contrib.auth.mixins import LoginRequiredMixin
from django.shortcuts import redirect, render
from django.views import View
from .models import Piloto, Pais, Escuderia, Circuito, Carrera, Usuario
from django.urls import reverse_lazy
from django.db.models import Sum
from .forms import CarreraForm
from django.core.exceptions import ObjectDoesNotExist

from django.views.generic import (
    ListView,
    DetailView,
    DeleteView,
    UpdateView,
    CreateView,
)

# region Menú de Admin

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
        piloto = self.request.GET.get('piloto')
        circuito = self.request.GET.get('circuito')
    
        context['circuitos'] = Circuito.objects.all()
        context['carreras'] = Carrera.objects.all()
        if piloto != 'todo' and piloto is not None:
            try:
                pilotobject = Piloto.objects.get(nombre__contains=piloto)
                context['carreras'] = context['carreras'].filter(piloto=pilotobject)
            except ObjectDoesNotExist:
                pass
        if circuito != 'todo' and circuito is not None:
            context['carreras'] = context['carreras'].filter(circuito=circuito)
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
    fields = ['nombre', 'bandera']
    template_name = "mundialitopx/admin/paises/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearPais(CreateView):
    model = Pais
    fields = ['nombre', 'bandera']
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
    fields = ['nombre', 'alias', 'monoplaza', 'pais', 'logo', 'puesto', 'descripcion']
    template_name = "mundialitopx/admin/escuderias/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearEscuderia(CreateView):
    model = Escuderia
    fields = ['nombre', 'alias', 'monoplaza', 'pais', 'logo', 'puesto', 'descripcion']
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
    fields = ['nombre', 'dorsal', 'escuderia', 'pais', 'foto', 'puesto', 'biografia']
    template_name = "mundialitopx/admin/pilotos/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearPiloto(CreateView):
    model = Piloto
    fields = ['nombre', 'dorsal', 'escuderia', 'pais', 'foto', 'puesto', 'biografia']
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
    fields = ['nombre', 'alias', 'pista', 'pais']
    template_name = "mundialitopx/admin/circuitos/editar.html"
    template_name_suffix = "_update_form"
    success_url = reverse_lazy("admin")
    
class CrearCircuito(CreateView):
    model = Circuito
    fields = ['nombre', 'alias', 'pista', 'pais']
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

class CrearCarrera(CreateView):
    nombre_template = "mundialitopx/admin/carreras/crear.html"
    fields = ['piloto', 'circuito', 'puesto']
    def get(self, request):
        pilotos = Piloto.objects.all()
        circuitos = Circuito.objects.all()
        return render(request, self.nombre_template, {'circuitos': circuitos, 'pilotos': pilotos})

    def post(self, request):
        form = CarreraForm(request.POST)
        if form.is_valid():
            puesto = form.cleaned_data["puesto"]
            pilotoform = form.cleaned_data["piloto"]
            circuito = form.cleaned_data["circuito"]
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
            carrera.puesto = puesto
            carrera.puntos = puntos
            carrera.piloto = pilotoform
            carrera.circuito = circuito
            carrera.save()

            piloto.puntos += puntos
            piloto.save()
            escuderia.puntos += puntos
            escuderia.save()

        return redirect('carrera')

# endregion
