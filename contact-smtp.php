<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit();
}

// Get and sanitize form data
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$organization = htmlspecialchars(trim($_POST['organization'] ?? ''));
$message = nl2br(htmlspecialchars(trim($_POST['message'] ?? '')));

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo "Please fill in all required fields";
    exit();
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Invalid email address";
    exit();
}

// Email configuration
$to = "contact@infosutra.co.in";
$subject = "New Contact Form Submission - " . $name;

// Create beautiful HTML email body
$htmlBody = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>
<body style="margin: 0; padding: 0; font-family: \'Inter\', \'Segoe UI\', Arial, sans-serif; background-color: #f5f6f7;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f6f7; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #53c2c5 0%, #7bae4a 50%, #c9d86a 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 0.5px;">
                                📬 New Contact Form Submission
                            </h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.95); font-size: 16px;">
                                Someone wants to connect with InfoSutra
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Contact Details Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, rgba(83, 194, 197, 0.1) 0%, rgba(123, 174, 74, 0.1) 100%); border-left: 4px solid #53c2c5; padding: 20px; border-radius: 8px;">
                                        <h2 style="margin: 0 0 20px 0; color: #2f8fa3; font-size: 20px; font-weight: 600;">
                                            Contact Information
                                        </h2>
                                        
                                        <!-- Name -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
                                            <tr>
                                                <td width="120" style="color: #4a4a4a; font-size: 14px; font-weight: 600; vertical-align: top; padding-right: 10px;">
                                                    👤 Name:
                                                </td>
                                                <td style="color: #2f2f2f; font-size: 16px; font-weight: 500;">
                                                    ' . $name . '
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <!-- Email -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
                                            <tr>
                                                <td width="120" style="color: #4a4a4a; font-size: 14px; font-weight: 600; vertical-align: top; padding-right: 10px;">
                                                    ✉️ Email:
                                                </td>
                                                <td style="color: #2f2f2f; font-size: 16px;">
                                                    <a href="mailto:' . $email . '" style="color: #53c2c5; text-decoration: none; font-weight: 500;">
                                                        ' . $email . '
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <!-- Organization -->
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="120" style="color: #4a4a4a; font-size: 14px; font-weight: 600; vertical-align: top; padding-right: 10px;">
                                                    🏢 Organization:
                                                </td>
                                                <td style="color: #2f2f2f; font-size: 16px; font-weight: 500;">
                                                    ' . ($organization ?: '<em style="color: #999;">Not provided</em>') . '
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Message Card -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background: #f5f6f7; border-left: 4px solid #7bae4a; padding: 20px; border-radius: 8px;">
                                        <h2 style="margin: 0 0 15px 0; color: #2f8fa3; font-size: 20px; font-weight: 600;">
                                            💬 Message
                                        </h2>
                                        <div style="color: #2f2f2f; font-size: 15px; line-height: 1.7; white-space: pre-wrap;">
                                            ' . $message . '
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>
                    
                    <!-- Call to Action -->
                    <tr>
                        <td style="padding: 0 30px 40px 30px; text-align: center;">
                            <a href="mailto:' . $email . '" style="display: inline-block; background: linear-gradient(135deg, #53c2c5, #7bae4a); color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 50px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 15px rgba(83, 194, 197, 0.3); transition: all 0.3s ease;">
                                📧 Reply to ' . $name . '
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2f8fa3 0%, #53c2c5 100%); padding: 25px 30px; text-align: center;">
                            <p style="margin: 0 0 10px 0; color: rgba(255, 255, 255, 0.95); font-size: 14px; line-height: 1.6;">
                                This email was sent from the contact form on your website
                            </p>
                            <p style="margin: 0; color: rgba(255, 255, 255, 0.8); font-size: 12px;">
                                © ' . date('Y') . ' InfoSutra Consultancy Pvt Ltd. All rights reserved.
                            </p>
                            <div style="margin-top: 20px;">
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/infosutra.consultancy" target="_blank" rel="noopener noreferrer" aria-label="Facebook" style="display: inline-block; width: 48px; height: 48px; background-color: #1877F2; border-radius: 50%; text-align: center; line-height: 48px; margin: 0 6px; text-decoration: none; vertical-align: middle;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-top: 14px;">
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" fill="#ffffff" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/company/infosutra-consultancy" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" style="display: inline-block; width: 48px; height: 48px; background-color: #0A66C2; border-radius: 50%; text-align: center; line-height: 48px; margin: 0 6px; text-decoration: none; vertical-align: middle;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-top: 14px;">
                                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z" fill="#ffffff"/>
                                        <circle cx="4" cy="4" r="2" fill="#ffffff"/>
                                    </svg>
                                </a>
                                <!-- X (Twitter) -->
                                <a href="https://x.com/InfoSutracoin" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" style="display: inline-block; width: 48px; height: 48px; background-color: #000000; border-radius: 50%; text-align: center; line-height: 48px; margin: 0 6px; text-decoration: none; vertical-align: middle;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-top: 14px;">
                                        <path d="M4 4l9.68 13L4 20h2.48l7.27-9.27L19 20h5l-9.68-13L23 4h-2.48l-7.27 9.27L9 4H4z" fill="#ffffff"/>
                                    </svg>
                                </a>
                                <!-- YouTube -->
                                <a href="https://www.youtube.com/@InfoSutraConsultancyPVTLTD" target="_blank" rel="noopener noreferrer" aria-label="YouTube" style="display: inline-block; width: 48px; height: 48px; background-color: #FF0000; border-radius: 50%; text-align: center; line-height: 48px; margin: 0 6px; text-decoration: none; vertical-align: middle;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle; margin-top: 14px;">
                                        <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z" fill="#ffffff"/>
                                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#FF0000"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
';

// Plain text version for email clients that don't support HTML
$plainTextBody = "New Contact Form Submission\n\n";
$plainTextBody .= "Contact Information:\n";
$plainTextBody .= "Name: " . $name . "\n";
$plainTextBody .= "Email: " . $email . "\n";
$plainTextBody .= "Organization: " . ($organization ?: 'Not provided') . "\n\n";
$plainTextBody .= "Message:\n" . strip_tags($message) . "\n\n";
$plainTextBody .= "---\n";
$plainTextBody .= "This email was sent from the contact form on your website.\n";
$plainTextBody .= "© " . date('Y') . " InfoSutra Consultancy Pvt Ltd.";

// Email headers for HTML email
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"boundary-" . md5(time()) . "\"\r\n";
$headers .= "From: InfoSutra Website <noreply@" . $_SERVER['HTTP_HOST'] . ">\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Create multipart message
$boundary = "boundary-" . md5(time());
$emailBody = "--" . $boundary . "\r\n";
$emailBody .= "Content-Type: text/plain; charset=UTF-8\r\n";
$emailBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$emailBody .= $plainTextBody . "\r\n\r\n";
$emailBody .= "--" . $boundary . "\r\n";
$emailBody .= "Content-Type: text/html; charset=UTF-8\r\n";
$emailBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$emailBody .= $htmlBody . "\r\n\r\n";
$emailBody .= "--" . $boundary . "--";

// Send email
if (mail($to, $subject, $emailBody, $headers)) {
    http_response_code(200);
    echo "Message sent successfully";
} else {
    http_response_code(500);
    echo "Failed to send message. Please try again later.";
}
?>