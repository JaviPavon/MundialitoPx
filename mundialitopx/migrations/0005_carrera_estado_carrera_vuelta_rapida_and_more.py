# Generated by Django 4.2.7 on 2024-02-01 18:20

import django.core.validators
from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('mundialitopx', '0004_alter_circuito_pista_alter_escuderia_monoplaza_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='carrera',
            name='estado',
            field=models.CharField(blank=True, choices=[('DSQ', 'DSQ'), ('DNF', 'DNF')], max_length=3, null=True),
        ),
        migrations.AddField(
            model_name='carrera',
            name='vuelta_rapida',
            field=models.BooleanField(default=False),
        ),
        migrations.AlterField(
            model_name='carrera',
            name='puesto',
            field=models.IntegerField(blank=True, null=True, validators=[django.core.validators.MinValueValidator(1), django.core.validators.MaxValueValidator(20)]),
        ),
    ]
