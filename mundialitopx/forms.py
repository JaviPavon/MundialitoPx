from django import forms
from .models import Carrera, Usuario
from django.contrib.auth.forms import UserCreationForm


class CarreraForm(forms.ModelForm):
    class Meta:
        model = Carrera
        fields = ["piloto", "circuito", "puesto", "estado", "vuelta_rapida"]


class RegisterForm(UserCreationForm):
    email = forms.EmailField()

    class Meta:
        model = Usuario
        fields = [
            "username",
            "first_name",
            "last_name",
            "email",
            "password1",
            "password2",
        ]
