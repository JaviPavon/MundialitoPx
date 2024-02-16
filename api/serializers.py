from mundialitopx.models import Noticia
from rest_framework import serializers

class NoticiaSerializer(serializers.ModelSerializer):
    class Meta:
        model = Noticia
        fields = ('circuito','escuderia' ,'piloto'  ,'autor' ,'titulo' ,'subtitulo'  ,'cuerpo' ,'fecha_publicacion' ,'imagen' )