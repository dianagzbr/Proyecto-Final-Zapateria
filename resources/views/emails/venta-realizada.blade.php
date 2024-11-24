<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta Realizada</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
        <!-- Header -->
        <div style="background-color: #bf0f85; color: #ffffff; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">¡Nueva Venta Registrada!</h1>
        </div>
        
        <!-- Body -->
        <div style="padding: 20px;">
            <p style="font-size: 16px; color: #333;">Hola,</p>
            <p style="font-size: 16px; color: #333;">
                Se ha registrado una nueva venta en el sistema. A continuación, encontrarás los detalles:
            </p>
            
            <!-- Sale Details -->
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>ID de la Venta</strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $venta->id }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Total</strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">$ {{ number_format($venta->total, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Fecha</strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $venta->fecha_hora }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Impuesto</strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">$ {{ number_format($venta->impuesto, 2) }}</td>
                </tr>
            </table>
            
            <!-- Button -->
            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ route('ventas.show', $venta) }}" 
                   style="display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #bf0f85; text-decoration: none; border-radius: 5px;">
                   Ver Detalles de la Venta
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f4f4f4; color: #555; text-align: center; padding: 10px; font-size: 12px;">
            <p style="margin: 0;">Este es un correo automático. Por favor, no respondas a este mensaje.</p>
            <p style="margin: 0;">© {{ date('Y') }} Calzado Pacheco. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
