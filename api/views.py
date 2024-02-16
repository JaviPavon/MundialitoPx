from .serializers import NoticiaSerializer
from rest_framework import viewsets,permissions
from mundialitopx.models import Noticia

class NoticiaViewSet(viewsets.ModelViewSet):
    queryset = Noticia.objects.all()
    serializer_class = NoticiaSerializer
    permission_classes = [permissions.AllowAny]