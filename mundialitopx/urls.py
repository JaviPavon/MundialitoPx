from django.urls import path
from . import views
from django.contrib.admin.views.decorators import staff_member_required
from django.contrib.auth.decorators import login_required
from .views import (
    ListPilotos, 
    ListPaises, 
    ListCircuitos, 
    ListEscuderias, 
    ListCarreras, 

    DetallesPais, 
    CrearPais, 
    EditarPais, 
    BorrarPais, 

    DetallesPiloto, 
    CrearPiloto, 
    EditarPiloto, 
    BorrarPiloto, 

    DetallesEscuderia,
    CrearEscuderia, 
    EditarEscuderia, 
    BorrarEscuderia, 

    DetallesCircuito, 
    CrearCircuito, 
    EditarCircuito, 
    BorrarCircuito, 

    DetallesCarrera, 
    CrearCarrera, 
    EditarCarrera, 
    BorrarCarrera, 
)

urlpatterns = [
    path('', staff_member_required(views.admin), name='admin'),
    path('inicio/admin/piloto', staff_member_required(ListPilotos.as_view()), name='piloto'),
    path('inicio/admin/pais', staff_member_required(ListPaises.as_view()), name='pais'),
    path('inicio/admin/escuderia', staff_member_required(ListEscuderias.as_view()), name='escuderia'),
    path('inicio/admin/circuito', staff_member_required(ListCircuitos.as_view()), name='circuito'),
    path('inicio/admin/carrera', staff_member_required(ListCarreras.as_view()), name='carrera'),

    path('inicio/admin/pais/detalle/<int:pk>', DetallesPais.as_view(), name='detalle_pais'),
    path('inicio/admin/pais/borrar/<int:pk>', BorrarPais.as_view(), name='borrar_pais'),
    path('inicio/admin/pais/crear', CrearPais.as_view(), name='crear_pais'),
    path('inicio/admin/pais/editar/<int:pk>', EditarPais.as_view(), name='editar_pais'),

    path('inicio/admin/ecuderia/detalle/<int:pk>', DetallesEscuderia.as_view(), name='detalle_escuderia'),
    path('inicio/admin/ecuderia/borrar/<int:pk>', BorrarEscuderia.as_view(), name='borrar_escuderia'),
    path('inicio/admin/ecuderia/crear', CrearEscuderia.as_view(), name='crear_escuderia'),
    path('inicio/admin/ecuderia/editar/<int:pk>', EditarEscuderia.as_view(), name='editar_escuderia'),

    path('inicio/admin/piloto/detalle/<int:pk>', DetallesPiloto.as_view(), name='detalle_piloto'),
    path('inicio/admin/piloto/borrar/<int:pk>', BorrarPiloto.as_view(), name='borrar_piloto'),
    path('inicio/admin/piloto/crear', CrearPiloto.as_view(), name='crear_piloto'),
    path('inicio/admin/piloto/editar/<int:pk>', EditarPiloto.as_view(), name='editar_piloto'),

    path('inicio/admin/circuito/detalle/<int:pk>', DetallesCircuito.as_view(), name='detalle_circuito'),
    path('inicio/admin/circuito/borrar/<int:pk>', BorrarCircuito.as_view(), name='borrar_circuito'),
    path('inicio/admin/circuito/crear', CrearCircuito.as_view(), name='crear_circuito'),
    path('inicio/admin/circuito/editar/<int:pk>', EditarCircuito.as_view(), name='editar_circuito'),

    path('inicio/admin/carrera/detalle/<int:pk>', DetallesCarrera.as_view(), name='detalle_carrera'),
    path('inicio/admin/carrera/borrar/<int:pk>', BorrarCarrera.as_view(), name='borrar_carrera'),
    path('inicio/admin/carrera/crear', CrearCarrera.as_view(), name='crear_carrera'),
    path('inicio/admin/carrera/editar/<int:pk>', EditarCarrera.as_view(), name='editar_carrera'),

]