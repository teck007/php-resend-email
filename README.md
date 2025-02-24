# PHP Resend Email

Backend simple en PHP que permite comunicarse con la API de Resend para el envio de correos, los datos se reciben mediante `POST`. Utiliza el servicio [Resend](https://resend.com/).

## Características
- Recibe datos de correo por `POST`.
- Utiliza la API de Resend para el envío.
- Responde con JSON indicando el éxito o fallo del envío.

## Requisitos
- PHP 7.4 o superior.
- Una cuenta en Resend y una API Key.
- Composer (para instalar dependencias si es necesario).

## Instalación
1. Clonar el repositorio:
   ```sh
   git clone https://github.com/teck007/php-resend-email.git
   cd tu-repo
   ```
2. Instalar dependencias:
   ```sh
   composer install
   ```
3. Crea el archivo `.env`:
   ```env
    RESEND_API_KEY=API Key entregado por resend.com
    RESEND_EMAIL_FROM=onboarding@resend.dev
    RESEND_EMAIL_TO=email que recibe los correos, debe ser el mismo correo configurado en resend
   ```
4. Iniciar un servidor local:
   ```sh
   php -S localhost:8000
   ```

## Licencia
MIT License

