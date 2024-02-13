import datetime
from wsgiref.validate import validator
from django.conf import settings
from django.db import models
from django.utils import timezone
from django.contrib.auth.models import AbstractUser
from django.core.validators import MaxValueValidator,MinValueValidator

class Usuario(AbstractUser):
    fotoperfil = models.ImageField(upload_to='media/foto-perfil/', null=True, blank=True)

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
    silueta = models.ImageField(upload_to='media/silueta/', null=True, blank=True)
    pais = models.ForeignKey(Pais, on_delete=models.CASCADE)
    fecha = models.DateField( null=True, blank=True)

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

    circuito = models.ForeignKey(Circuito, on_delete=models.CASCADE, null=True, blank=True)
    escuderia = models.ManyToManyField(Escuderia, blank=True)
    piloto = models.ManyToManyField(Piloto, blank=True)
    autor = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    titulo = models.CharField(max_length=100)
    subtitulo = models.CharField(max_length=100)
    cuerpo = models.TextField()
    fecha_publicacion = models.DateField()
    imagen = models.ImageField(upload_to='media/noticia/', null=True, blank=True)

    def __str__(self):
        return "'" + str(self.titulo)+ "' escrito por " + str(self.autor)
    
class Comentario(models.Model):
    autor = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    noticia = models.ForeignKey(Noticia, on_delete=models.CASCADE)
    comentario = models.TextField()
    fecha_publicacion = models.DateField()


    def __str__(self):
        return "'" + str(self.comentario)+ "' escrito por " + str(self.autor) + " de " + str(self.noticia)



class Liga(models.Model):
    estado = [('Privado', 'Privado'),('Publico', 'Publico'),]

    usuarios = models.ManyToManyField(Usuario)
    nombre = models.CharField(max_length=30)
    contraseña = models.CharField(max_length=15)
    estado = models.CharField(max_length=7, choices=estado, null=True, blank=True)




    def __str__(self):
        return str(self.nombre)
    
class PilotoJuego(models.Model):

    piloto = models.ForeignKey(Piloto, on_delete=models.CASCADE)
    puntos_totales = models.IntegerField(default=0)
    valor = models.IntegerField(default=0)




    def __str__(self):
        return str(self.piloto.nombre)
    

class Jornada(models.Model):

    estado = [('DSQ', 'DSQ'),('DNF', 'DNF'),]

    piloto = models.ForeignKey(PilotoJuego, on_delete=models.CASCADE)
    circuito = models.ForeignKey(Circuito, on_delete=models.CASCADE)
    puntos_jornada = models.IntegerField(default=0)
    adelantamiento = models.IntegerField(default=0)
    estado = models.CharField(max_length=3, choices=estado, null=True, blank=True)
    q2 = models.BooleanField(default=False)
    q3 = models.BooleanField(default=False)
    vuelta_rapida = models.BooleanField(default=False)
    amonestacion = models.IntegerField(default=0)
    sancion3 = models.IntegerField(default=0)
    sancion5 = models.IntegerField(default=0)

    def __str__(self):
        return str(self.piloto.piloto.nombre) + " en " + str(self.circuito.nombre) + ": "+ self.puntos_jornada 
    

class Jugador(models.Model):

    piloto = models.ManyToManyField(PilotoJuego)
    usuario = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    liga = models.ForeignKey(Liga, on_delete=models.CASCADE)
    saldo = models.IntegerField(default=1500000)
    puntos_totales = models.IntegerField(default=0)
    puesto = models.IntegerField(validators=[MinValueValidator(1)], null=True, blank=True)


    def __str__(self):
        return str(self.usuario.username) + " en " + str(self.liga.nombre)
    