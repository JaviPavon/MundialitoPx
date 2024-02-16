from rest_framework import routers
from .views import NoticiaViewSet

app_name = 'api'

router = routers.DefaultRouter()

router.register('noticias', NoticiaViewSet, 'noticia_api')

urlpatterns =router.urls