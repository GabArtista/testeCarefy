<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validação dos campos do formulário
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email',
            'telefone' => 'required|string',
            'mensagem' => 'required|string',
        ]);

        $mail = new PHPMailer(true);

        try {
            // Configuração do PHPMailer para SMTP
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST'); // Definido no .env
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME'); // Definido no .env
            $mail->Password = env('MAIL_PASSWORD'); // Utilize a senha de app do Gmail definida no .env
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Criptografia SSL
            $mail->Port = env('MAIL_PORT'); // Porta configurada no .env (465)

            // Remetente
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            // Destinatário
            $mail->addAddress('gabrielwillian@dozecrew.com', 'Joe User');
            $mail->addReplyTo($request->email, $request->nome); // Responder para o e-mail do lead

            // Conteúdo do e-mail
            $mail->isHTML(true); // Definindo o formato como HTML
            $mail->Subject = 'Chegou um novo Lead da Landing Page de Captação';
            $mail->Body = "Lead da Landing Page, segue informação de contato:<br>
                           Nome: {$request->nome}<br>
                           E-mail: {$request->email}<br>
                           Telefone: {$request->telefone}<br>
                           Mensagem: {$request->mensagem}<br>";
            $mail->AltBody = "Novo lead da Landing Page:\nNome: {$request->nome}\nE-mail: {$request->email}\nTelefone: {$request->telefone}\nMensagem: {$request->mensagem}";

            // Envio do e-mail
            $mail->send();

            return redirect('https://wa.me/5512997165911')->with('success', 'E-mail enviado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Erro no envio do e-mail: {$mail->ErrorInfo}");
        }
    }
}
