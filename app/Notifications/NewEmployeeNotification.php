<?php
// app/Notifications/NewEmployeeNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Empleado;

class NewEmployeeNotification extends Notification
{
    use Queueable;

    protected $empleado;
    protected $isAdmin;
    protected $password;

    public function __construct(Empleado $empleado, $isAdmin = false, $password = null)
    {   
        $this->empleado = $empleado;
        $this->isAdmin = $isAdmin;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->isAdmin) {
            return $this->toAdminMail();
        }
        return $this->toEmployeeMail();
    }

    private function toAdminMail()
    {
        return (new MailMessage)
            ->subject('Nuevo Empleado Registrado')
            ->greeting('Hola Administrador,')
            ->line('Se ha registrado un nuevo empleado en el sistema:')
            ->line('Nombre: ' . $this->empleado->nombres . ' ' . $this->empleado->apellidos)
            ->line('Identificación: ' . $this->empleado->identificacion)
            ->line('Cargo: ' . $this->empleado->cargos->pluck('nombre')->implode(', '))
            ->action('Ver Detalles del Empleado', url('/empleados/' . $this->empleado->id))
            ->line('Por favor, revisa los detalles del registro.');
    }

    private function toEmployeeMail()
    {
        $user = $this->empleado->user; 

    return (new MailMessage)
        ->subject('Bienvenido a la Empresa')
        ->greeting('Hola ' . $this->empleado->nombres . ',')
        ->line('¡Bienvenido a nuestro sistema!')
        ->line('Tus credenciales de acceso son:')
        ->line('Email: ' . ($user ? $user->email : 'No asignado'))
        ->line('Contraseña: ' . $this->password)
        ->line('Por favor, cambia tu contraseña después del primer inicio de sesión.')
        ->action('Iniciar Sesión', url('/login'))
        ->line('Si tienes alguna pregunta, no dudes en contactar a tu supervisor.');
    }
}