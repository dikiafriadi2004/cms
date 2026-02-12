<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih Telah Menghubungi Kami</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 50px 40px; text-align: center;">
                            @if($hasLogo ?? false)
                            <img src="{{ $logo }}" alt="{{ $siteName }}" style="max-width: 180px; height: auto; margin-bottom: 20px;">
                            @else
                            <div style="background-color: #ffffff; width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 8L10.89 13.26C11.2187 13.4793 11.6049 13.5963 12 13.5963C12.3951 13.5963 12.7813 13.4793 13.11 13.26L21 8M5 19H19C19.5304 19 20.0391 18.7893 20.4142 18.4142C20.7893 18.0391 21 17.5304 21 17V7C21 6.46957 20.7893 5.96086 20.4142 5.58579C20.0391 5.21071 19.5304 5 19 5H5C4.46957 5 3.96086 5.21071 3.58579 5.58579C3.21071 5.96086 3 6.46957 3 7V17C3 17.5304 3.21071 18.0391 3.58579 18.4142C3.96086 18.7893 4.46957 19 5 19Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            @endif
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1.3;">
                                Terima Kasih!
                            </h1>
                            <p style="margin: 12px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                Pesan Anda telah kami terima
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 50px 40px; color: #374151; font-size: 16px; line-height: 1.8;">
                            <p style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600; color: #1f2937;">
                                Halo {{ $contact->name }},
                            </p>
                            
                            <p style="margin: 0 0 20px 0;">
                                Terima kasih telah menghubungi <strong>{{ $siteName }}</strong>. Kami telah menerima pesan Anda dan akan segera merespons dalam waktu <strong>1x24 jam</strong>.
                            </p>
                            
                            <p style="margin: 0 0 20px 0;">
                                Berikut adalah ringkasan pesan yang Anda kirimkan:
                            </p>
                            
                            <!-- Message Summary Box -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 12px; overflow: hidden; margin: 30px 0;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding-bottom: 15px;">
                                                    <p style="margin: 0; font-size: 12px; font-weight: 600; color: #0369a1; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Subjek
                                                    </p>
                                                    <p style="margin: 8px 0 0 0; font-size: 16px; font-weight: 600; color: #1f2937;">
                                                        {{ $contact->subject }}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 15px; border-top: 1px solid rgba(3, 105, 161, 0.2);">
                                                    <p style="margin: 0; font-size: 12px; font-weight: 600; color: #0369a1; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        Pesan Anda
                                                    </p>
                                                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #374151; white-space: pre-wrap; line-height: 1.6;">{{ $contact->message }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 15px; border-top: 1px solid rgba(3, 105, 161, 0.2);">
                                                    <p style="margin: 0; font-size: 12px; color: #6b7280;">
                                                        <strong>Tanggal:</strong> {{ $contact->created_at->format('d F Y, H:i') }} WIB
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 30px 0 20px 0;">
                                Tim kami akan meninjau pesan Anda dan memberikan respons yang sesuai. Jika Anda memiliki pertanyaan mendesak, silakan hubungi kami melalui:
                            </p>
                            
                            <!-- Contact Info -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 20px 0;">
                                @if($contactEmail)
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 12px; vertical-align: top;">
                                                    <div style="width: 24px; height: 24px; background-color: #dbeafe; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                        <span style="color: #2563eb; font-size: 14px;">✉</span>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <p style="margin: 0; font-size: 14px; color: #6b7280;">Email</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 15px; font-weight: 600; color: #1f2937;">
                                                        <a href="mailto:{{ $contactEmail }}" style="color: #2563eb; text-decoration: none;">{{ $contactEmail }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                
                                @if($contactPhone)
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 12px; vertical-align: top;">
                                                    <div style="width: 24px; height: 24px; background-color: #dcfce7; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                        <span style="color: #16a34a; font-size: 14px;">☎</span>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <p style="margin: 0; font-size: 14px; color: #6b7280;">Telepon</p>
                                                    <p style="margin: 4px 0 0 0; font-size: 15px; font-weight: 600; color: #1f2937;">
                                                        <a href="tel:{{ $contactPhone }}" style="color: #16a34a; text-decoration: none;">{{ $contactPhone }}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                            </table>
                            
                            <p style="margin: 30px 0 0 0; color: #6b7280; font-size: 14px;">
                                Hormat kami,<br>
                                <strong style="color: #1f2937;">Tim {{ $siteName }}</strong>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 40px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 12px 0; font-weight: 600; color: #374151; font-size: 16px;">
                                {{ $siteName }}
                            </p>
                            
                            @if($contactAddress)
                            <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                {{ $contactAddress }}
                            </p>
                            @endif
                            
                            <!-- Social Media -->
                            @if($socialFacebook || $socialInstagram || $socialTwitter)
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 20px auto;">
                                <tr>
                                    @if($socialFacebook)
                                    <td style="padding: 0 8px;">
                                        <a href="{{ $socialFacebook }}" style="display: inline-block; width: 36px; height: 36px; background-color: #3b5998; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">f</a>
                                    </td>
                                    @endif
                                    @if($socialInstagram)
                                    <td style="padding: 0 8px;">
                                        <a href="{{ $socialInstagram }}" style="display: inline-block; width: 36px; height: 36px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">📷</a>
                                    </td>
                                    @endif
                                    @if($socialTwitter)
                                    <td style="padding: 0 8px;">
                                        <a href="{{ $socialTwitter }}" style="display: inline-block; width: 36px; height: 36px; background-color: #1da1f2; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">🐦</a>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                            @endif
                            
                            <p style="margin: 20px 0 0 0; font-size: 12px; color: #9ca3af;">
                                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.<br>
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
