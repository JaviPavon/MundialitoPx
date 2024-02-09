# Generated by Django 4.2.7 on 2024-02-09 18:16

from django.conf import settings
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('mundialitopx', '0004_alter_circuito_fecha'),
    ]

    operations = [
        migrations.CreateModel(
            name='Liga',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nombre', models.CharField(max_length=30)),
                ('contraseña', models.CharField(max_length=15)),
                ('estado', models.CharField(blank=True, choices=[('Privado', 'Privado'), ('Publico', 'Publico')], max_length=7, null=True)),
                ('usuarios', models.ManyToManyField(to=settings.AUTH_USER_MODEL)),
            ],
        ),
    ]
