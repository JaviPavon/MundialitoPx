from django.contrib import admin
from .models import (
    Usuario,
    Pais,
    Piloto,
    Escuderia,
    Carrera,
    Circuito,
    Noticia,
    Comentario,
    PilotoJuego,
    Liga,
    Jugador,
)
from django.contrib.auth.admin import UserAdmin

class CustomUserAdmin(UserAdmin):
    model = Usuario
    fieldsets = UserAdmin.fieldsets + (
    (None, {'fields': ('fotoperfil',)}),
    )
    add_fieldsets = UserAdmin.add_fieldsets + (
    (None, {'fields': ('fotoperfil',)}),
    )

admin.site.register(Usuario,CustomUserAdmin)
admin.site.register(Pais)
admin.site.register(Piloto)
admin.site.register(Escuderia)
admin.site.register(Carrera)
admin.site.register(Circuito)
admin.site.register(Noticia)
admin.site.register(Comentario)
admin.site.register(PilotoJuego)
admin.site.register(Liga)
admin.site.register(Jugador)
