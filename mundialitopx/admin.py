from django.contrib import admin
from .models import Usuario, Pais, Piloto, Escuderia, Carrera, Circuito, Noticia, Comentario
from django.contrib.auth.admin import UserAdmin


admin.site.register(Usuario,UserAdmin)
admin.site.register(Pais)
admin.site.register(Piloto)
admin.site.register(Escuderia)
admin.site.register(Carrera)
admin.site.register(Circuito)
admin.site.register(Noticia)
admin.site.register(Comentario)
