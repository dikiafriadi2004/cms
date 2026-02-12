<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari Contact Form</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 50px 40px; text-align: center;">
                            @if($hasLogo ?? false)
                            <img src="{{ $logo }}" alt="{{ $siteName }}" style="max-width: 180px; height: auto; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;">
                            @else
                            <div style="background-color: #ffffff; width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            @endif
                            
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1.3;">
                                Pesan Baru!
                            </h1>
                            <p style="margin: 12px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                Ada pesan baru dari contact form
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 50px 40px; color: #374151; font-size: 16px; line-height: 1.8;">
                            <p style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600; color: #1f2937;">
                                Halo Admin,
                            </p>
                            
                            <p style="margin: 0 0 30px 0;">
                                Anda menerima pesan baru dari contact form website. Berikut adalah detailnya:
                            </p>
                            
                            <!-- Sender Info -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; overflow: hidden; margin: 30px 0;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <p style="margin: 0 0 20px 0; font-size: 14px; font-weight: 600; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Informasi Pengirim
                                        </p>
                                        
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <p style="margin: 0; font-size: 12px; color: #92400e; font-weight: 600;">NAMA</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600; color: #1f2937;">{{ $contact->name }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <p style="margin: 0; font-size: 12px; color: #92400e; font-weight: 600;">EMAIL</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 16px; color: #1f2937;">
                                                        <a href="mailto:{{ $contact->email }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">{{ $contact->email }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            @if($contact->phone)
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <p style="margin: 0; font-size: 12px; color: #92400e; font-weight: 600;">TELEPON</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 16px; color: #1f2937;">
                                                        <a href="tel:{{ $contact->phone }}" style="color: #16a34a; text-decoration: none; font-weight: 500;">{{ $contact->phone }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <p style="margin: 0; font-size: 12px; color: #92400e; font-weight: 600;">TANGGAL</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">{{ $contact->created_at->format('d F Y, H:i') }} WIB</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <p style="margin: 0; font-size: 12px; color: #92400e; font-weight: 600;">IP ADDRESS</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280; font-family: monospace;">{{ $contact->ip_address }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Message Content -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f9fafb; border-radius: 12px; overflow: hidden; margin: 30px 0; border: 2px solid #e5e7eb;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <p style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Subjek
                                        </p>
                                        <p style="margin: 0 0 24px 0; font-size: 20px; font-weight: 700; color: #1f2937; line-height: 1.4;">
                                            {{ $contact->subject }}
                                        </p>
                                        
                                        <p style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Pesan
                                        </p>
                                        <p style="margin: 0; font-size: 15px; color: #374151; white-space: pre-wrap; line-height: 1.7;">{{ $contact->message }}</p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Action Button -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 40px auto;">
                                <tr>
                                    <td style="border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); text-align: center;">
                                        <a href="{{ $adminUrl }}" style="display: inline-block; padding: 16px 40px; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 16px; border-radius: 10px;">
                                            Lihat di Admin Panel →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 30px 0 0 0; padding: 20px; background-color: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 8px; font-size: 14px; color: #1e40af;">
                                <strong>💡 Tips:</strong> Balas pesan ini sesegera mungkin untuk memberikan pengalaman terbaik kepada pengunjung website Anda.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px 40px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                Email notifikasi otomatis dari {{ $siteName }}<br>
                                &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
