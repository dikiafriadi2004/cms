<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Pesan Anda</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 50px 40px; text-align: center;">
                            @php
                                $siteName = \App\Models\Setting::get('site_name', config('app.name'));
                                $logo = \App\Models\Setting::get('site_logo');
                            @endphp
                            
                            @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}" style="max-width: 180px; height: auto; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;">
                            @else
                            <div style="background-color: #ffffff; width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 20px; display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 10H13C13.5304 10 14.0391 10.2107 14.4142 10.5858C14.7893 10.9609 15 11.4696 15 12V21M3 10V18C3 18.5304 3.21071 19.0391 3.58579 19.4142C3.96086 19.7893 4.46957 20 5 20H13C13.5304 20 14.0391 19.7893 14.4142 19.4142C14.7893 19.0391 15 18.5304 15 18V12M3 10L10.5 3.5M15 12L20.5 6.5M15 21V12" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            @endif
                            
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1.3;">
                                Balasan untuk Anda
                            </h1>
                            <p style="margin: 12px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                Tim kami telah merespons pesan Anda
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 50px 40px; color: #374151; font-size: 16px; line-height: 1.8;">
                            <p style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600; color: #1f2937;">
                                Halo {{ $contact->name }},
                            </p>
                            
                            <p style="margin: 0 0 30px 0;">
                                Terima kasih atas kesabaran Anda. Berikut adalah balasan dari tim kami:
                            </p>
                            
                            <!-- Reply Message -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px; overflow: hidden; margin: 30px 0; border-left: 4px solid #10b981;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <div style="color: #374151; font-size: 15px; line-height: 1.7;">
                                            {!! $replyMessage !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Original Message -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f9fafb; border-radius: 12px; overflow: hidden; margin: 30px 0; border: 1px solid #e5e7eb;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <p style="margin: 0 0 16px 0; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Pesan Asli Anda
                                        </p>
                                        
                                        <p style="margin: 0 0 8px 0; font-size: 14px; color: #6b7280;">
                                            <strong style="color: #374151;">Subjek:</strong> {{ $contact->subject }}
                                        </p>
                                        <p style="margin: 0 0 16px 0; font-size: 14px; color: #6b7280;">
                                            <strong style="color: #374151;">Tanggal:</strong> {{ $contact->created_at->format('d F Y, H:i') }} WIB
                                        </p>
                                        
                                        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                                            <p style="margin: 0; font-size: 14px; color: #6b7280; white-space: pre-wrap; line-height: 1.6;">{{ $contact->message }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 30px 0 20px 0;">
                                Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali.
                            </p>
                            
                            @php
                                $contactEmail = \App\Models\Setting::get('contact_email');
                                $contactPhone = \App\Models\Setting::get('contact_phone');
                            @endphp
                            
                            <!-- Contact Info -->
                            @if($contactEmail || $contactPhone)
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 20px 0;">
                                @if($contactEmail)
                                <tr>
                                    <td style="padding: 8px 0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding-right: 12px; vertical-align: top;">
                                                    <div style="width: 24px; height: 24px; background-color: #dbeafe; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center;">
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
                                                    <div style="width: 24px; height: 24px; background-color: #dcfce7; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center;">
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
                            @endif
                            
                            <p style="margin: 30px 0 0 0; color: #6b7280; font-size: 14px;">
                                Hormat kami,<br>
                                <strong style="color: #1f2937;">Tim {{ $siteName }}</strong>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 40px; text-align: center; border-top: 1px solid #e5e7eb;">
                            @php
                                $contactAddress = \App\Models\Setting::get('contact_address');
                                $socialFacebook = \App\Models\Setting::get('social_facebook');
                                $socialInstagram = \App\Models\Setting::get('social_instagram');
                                $socialTwitter = \App\Models\Setting::get('social_twitter');
                            @endphp
                            
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
