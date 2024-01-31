# Generated by Django 4.2.9 on 2024-01-31 12:18

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('mundialitopx', '0003_alter_escuderia_logo'),
    ]

    operations = [
        migrations.AlterField(
            model_name='circuito',
            name='pista',
            field=models.ImageField(blank=True, null=True, upload_to='media/circuitos/'),
        ),
        migrations.AlterField(
            model_name='escuderia',
            name='monoplaza',
            field=models.ImageField(blank=True, null=True, upload_to='media/monoplazas/'),
        ),
        migrations.AlterField(
            model_name='pais',
            name='bandera',
            field=models.ImageField(blank=True, null=True, upload_to='media/banderas/'),
        ),
        migrations.AlterField(
            model_name='piloto',
            name='foto',
            field=models.ImageField(blank=True, null=True, upload_to='media/fotospilotos/'),
        ),
    ]
