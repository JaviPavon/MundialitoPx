from django import forms
from .models import Carrera

class CarreraForm(forms.ModelForm):
  class Meta:
    model = Carrera
    fields = ['piloto', 'circuito', 'puesto', 'estado', 'vuelta_rapida']