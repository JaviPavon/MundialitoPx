from django.urls import path
from . import views
from django.contrib.admin.views.decorators import staff_member_required
from django.contrib.auth.decorators import login_required
# from .views import (
# )

urlpatterns = [
    path('', staff_member_required(views.admin), name='admin'),
    path('inicio/admin/piloto', staff_member_required(views.pilotoAdmin), name='piloto'),
    path('inicio/admin/pais', staff_member_required(views.paisAdmin), name='pais'),
    path('inicio/admin/ecuderia', staff_member_required(views.escuderiaAdmin), name='escuderia'),
    path('inicio/admin/circuito', staff_member_required(views.circuitoAdmin), name='circuito'),
    path('inicio/admin/carrera', staff_member_required(views.carreraAdmin), name='carrera'),
]