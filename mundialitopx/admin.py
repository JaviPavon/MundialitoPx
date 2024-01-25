from django.contrib import admin
from .models import Usuario, Pais, Piloto, Escuderia, Carrera, Circuito
from django.contrib.auth.admin import UserAdmin


admin.site.register(Usuario,UserAdmin)
admin.site.register(Pais)
admin.site.register(Piloto)
admin.site.register(Escuderia)
admin.site.register(Carrera)
admin.site.register(Circuito)
