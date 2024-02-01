import datetime
from wsgiref.validate import validator
from django.conf import settings
from django.db import models
from django.utils import timezone
from django.contrib.auth.models import AbstractUser
from django.core.validators import MaxValueValidator,MinValueValidator

class Usuario(AbstractUser):

    def __str__(self):
        return self.username


class Pais(models.Model):
    nombre = models.CharField(max_length=100)
    bandera = models.ImageField(upload_to='media/banderas/', null=True, blank=True)

    def __str__(self):
        return self.nombre

    class Meta:
        verbose_name_plural = 'Paises'


class Circuito(models.Model):
    nombre = models.CharField(max_length=100)
    alias = models.CharField(max_length=100)
    pista = models.ImageField(upload_to='media/circuitos/', null=True, blank=True)
    pais = models.ForeignKey(Pais, on_delete=models.CASCADE)

    def __str__(self):
        return self.nombre

class Escuderia(models.Model):
    nombre = models.CharField(max_length=100)
    alias = models.CharField(max_length=100)
    monoplaza = models.ImageField(upload_to='media/monoplazas/', null=True, blank=True)
    pais = models.ForeignKey(Pais, on_delete=models.CASCADE)
    logo = models.ImageField(upload_to='media/logos/', null=True, blank=True)
    puesto = models.IntegerField(validators=[MinValueValidator(1),MaxValueValidator(20)])
    descripcion = models.TextField()
    puntos = models.IntegerField(default=0)

    def __str__(self):
        return self.nombre
    
class Piloto(models.Model):
    nombre = models.CharField(max_length=100)
    puntos = models.IntegerField(default=0)
    pais = models.ForeignKey(Pais, on_delete=models.CASCADE)
    dorsal = models.IntegerField()
    escuderia = models.ForeignKey(Escuderia, on_delete=models.CASCADE)
    puesto = models.IntegerField(validators=[MinValueValidator(1),MaxValueValidator(20)])
    biografia = models.TextField()
    foto = models.ImageField(upload_to='media/fotospilotos/', null=True, blank=True)

    def __str__(self):
        return self.nombre


class Carrera(models.Model):
    estado = [('DSQ', 'DSQ'),('DNF', 'DNF'),]

    circuito = models.ForeignKey(Circuito, on_delete=models.CASCADE)
    puesto = models.IntegerField(validators=[MinValueValidator(1),MaxValueValidator(20)], null=True, blank=True)
    piloto = models.ForeignKey(Piloto, on_delete=models.CASCADE)
    puntos = models.IntegerField(default=0)
    vuelta_rapida = models.BooleanField(default=False)
    estado = models.CharField(max_length=3, choices=estado, null=True, blank=True)




    def __str__(self):
        return str(self.piloto)+ " en " + str(self.circuito)

    class Meta:
        unique_together= ['circuito','piloto']


class Noticia(models.Model):
    autor = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    titulo = models.CharField(max_length=100)
    cuerpo = models.TextField()
    fecha_publicacion = models.DateField()
    imagen = models.ImageField(upload_to='media/noticia/', null=True, blank=True)




    def __str__(self):
        return "'" + str(self.titulo)+ "' escrito por " + str(self.autor)
