# Generated by Django 4.2.7 on 2024-02-13 21:45

from django.conf import settings
import django.contrib.auth.models
import django.contrib.auth.validators
import django.core.validators
from django.db import migrations, models
import django.db.models.deletion
import django.utils.timezone


class Migration(migrations.Migration):

    initial = True

    dependencies = [
        ('auth', '0012_alter_user_first_name_max_length'),
    ]

    operations = [
        migrations.CreateModel(
            name='Usuario',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('password', models.CharField(max_length=128, verbose_name='password')),
                ('last_login', models.DateTimeField(blank=True, null=True, verbose_name='last login')),
                ('is_superuser', models.BooleanField(default=False, help_text='Designates that this user has all permissions without explicitly assigning them.', verbose_name='superuser status')),
                ('username', models.CharField(error_messages={'unique': 'A user with that username already exists.'}, help_text='Required. 150 characters or fewer. Letters, digits and @/./+/-/_ only.', max_length=150, unique=True, validators=[django.contrib.auth.validators.UnicodeUsernameValidator()], verbose_name='username')),
                ('first_name', models.CharField(blank=True, max_length=150, verbose_name='first name')),
                ('last_name', models.CharField(blank=True, max_length=150, verbose_name='last name')),
                ('email', models.EmailField(blank=True, max_length=254, verbose_name='email address')),
                ('is_staff', models.BooleanField(default=False, help_text='Designates whether the user can log into this admin site.', verbose_name='staff status')),
                ('is_active', models.BooleanField(default=True, help_text='Designates whether this user should be treated as active. Unselect this instead of deleting accounts.', verbose_name='active')),
                ('date_joined', models.DateTimeField(default=django.utils.timezone.now, verbose_name='date joined')),
                ('fotoperfil', models.ImageField(blank=True, null=True, upload_to='media/foto-perfil/')),
                ('groups', models.ManyToManyField(blank=True, help_text='The groups this user belongs to. A user will get all permissions granted to each of their groups.', related_name='user_set', related_query_name='user', to='auth.group', verbose_name='groups')),
                ('user_permissions', models.ManyToManyField(blank=True, help_text='Specific permissions for this user.', related_name='user_set', related_query_name='user', to='auth.permission', verbose_name='user permissions')),
            ],
            options={
                'verbose_name': 'user',
                'verbose_name_plural': 'users',
                'abstract': False,
            },
            managers=[
                ('objects', django.contrib.auth.models.UserManager()),
            ],
        ),
        migrations.CreateModel(
            name='Circuito',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nombre', models.CharField(max_length=100)),
                ('alias', models.CharField(max_length=100)),
                ('pista', models.ImageField(blank=True, null=True, upload_to='media/circuitos/')),
                ('silueta', models.ImageField(blank=True, null=True, upload_to='media/silueta/')),
                ('fecha', models.DateField(blank=True, null=True)),
            ],
        ),
        migrations.CreateModel(
            name='Escuderia',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nombre', models.CharField(max_length=100)),
                ('alias', models.CharField(max_length=100)),
                ('monoplaza', models.ImageField(blank=True, null=True, upload_to='media/monoplazas/')),
                ('logo', models.ImageField(blank=True, null=True, upload_to='media/logos/')),
                ('puesto', models.IntegerField(validators=[django.core.validators.MinValueValidator(1), django.core.validators.MaxValueValidator(20)])),
                ('descripcion', models.TextField()),
                ('puntos', models.IntegerField(default=0)),
            ],
        ),
        migrations.CreateModel(
            name='Pais',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nombre', models.CharField(max_length=100)),
                ('bandera', models.ImageField(blank=True, null=True, upload_to='media/banderas/')),
            ],
            options={
                'verbose_name_plural': 'Paises',
            },
        ),
        migrations.CreateModel(
            name='Piloto',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nombre', models.CharField(max_length=100)),
                ('puntos', models.IntegerField(default=0)),
                ('dorsal', models.IntegerField()),
                ('puesto', models.IntegerField(validators=[django.core.validators.MinValueValidator(1), django.core.validators.MaxValueValidator(20)])),
                ('biografia', models.TextField()),
                ('foto', models.ImageField(blank=True, null=True, upload_to='media/fotospilotos/')),
                ('escuderia', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.escuderia')),
                ('pais', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.pais')),
            ],
        ),
        migrations.CreateModel(
            name='PilotoJuego',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('puntos_totales', models.IntegerField(default=0)),
                ('valor', models.IntegerField(default=0)),
                ('piloto', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.piloto')),
            ],
        ),
        migrations.CreateModel(
            name='Noticia',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('titulo', models.CharField(max_length=100)),
                ('subtitulo', models.CharField(max_length=100)),
                ('cuerpo', models.TextField()),
                ('fecha_publicacion', models.DateField()),
                ('imagen', models.ImageField(blank=True, null=True, upload_to='media/noticia/')),
                ('autor', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to=settings.AUTH_USER_MODEL)),
                ('circuito', models.ForeignKey(blank=True, null=True, on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.circuito')),
                ('escuderia', models.ManyToManyField(blank=True, to='mundialitopx.escuderia')),
                ('piloto', models.ManyToManyField(blank=True, to='mundialitopx.piloto')),
            ],
        ),
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
        migrations.CreateModel(
            name='Jugador',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('saldo', models.IntegerField(default=1500000)),
                ('puntos_totales', models.IntegerField(default=0)),
                ('puesto', models.IntegerField(blank=True, null=True, validators=[django.core.validators.MinValueValidator(1)])),
                ('liga', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.liga')),
                ('piloto', models.ManyToManyField(to='mundialitopx.pilotojuego')),
                ('usuario', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to=settings.AUTH_USER_MODEL)),
            ],
        ),
        migrations.CreateModel(
            name='Jornada',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('puntos_jornada', models.IntegerField(default=0)),
                ('adelantamiento', models.IntegerField(default=0)),
                ('estado', models.CharField(blank=True, choices=[('DSQ', 'DSQ'), ('DNF', 'DNF')], max_length=3, null=True)),
                ('q2', models.BooleanField(default=False)),
                ('q3', models.BooleanField(default=False)),
                ('vuelta_rapida', models.BooleanField(default=False)),
                ('amonestacion', models.IntegerField(default=0)),
                ('sancion3', models.IntegerField(default=0)),
                ('sancion5', models.IntegerField(default=0)),
                ('circuito', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.circuito')),
                ('piloto', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.pilotojuego')),
            ],
        ),
        migrations.AddField(
            model_name='escuderia',
            name='pais',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.pais'),
        ),
        migrations.CreateModel(
            name='Comentario',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('comentario', models.TextField()),
                ('fecha_publicacion', models.DateField()),
                ('autor', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to=settings.AUTH_USER_MODEL)),
                ('noticia', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.noticia')),
            ],
        ),
        migrations.AddField(
            model_name='circuito',
            name='pais',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.pais'),
        ),
        migrations.CreateModel(
            name='Carrera',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('puesto', models.IntegerField(blank=True, null=True, validators=[django.core.validators.MinValueValidator(1), django.core.validators.MaxValueValidator(20)])),
                ('puntos', models.IntegerField(default=0)),
                ('vuelta_rapida', models.BooleanField(default=False)),
                ('estado', models.CharField(blank=True, choices=[('DSQ', 'DSQ'), ('DNF', 'DNF')], max_length=3, null=True)),
                ('circuito', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.circuito')),
                ('piloto', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='mundialitopx.piloto')),
            ],
            options={
                'unique_together': {('circuito', 'piloto')},
            },
        ),
    ]
