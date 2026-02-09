<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
        .field { margin-bottom: 20px; }
        .label { font-weight: bold; color: #4b5563; margin-bottom: 5px; }
        .value { background: white; padding: 12px; border-radius: 6px; border: 1px solid #e5e7eb; }
        .footer { background: #374151; color: #9ca3af; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">📧 New Contact Message</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">You have received a new message from your website</p>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="label">👤 Name:</div>
                <div class="value">{{ $contact->name }}</div>
            </div>
            
            <div class="field">
                <div class="label">📧 Email:</div>
                <div class="value">{{ $contact->email }}</div>
            </div>
            
            @if($contact->phone)
            <div class="field">
                <div class="label">📱 Phone:</div>
                <div class="value">{{ $contact->phone }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="label">📝 Subject:</div>
                <div class="value">{{ $contact->subject }}</div>
            </div>
            
            <div class="field">
                <div class="label">💬 Message:</div>
                <div class="value" style="white-space: pre-wrap;">{{ $contact->message }}</div>
            </div>
            
            <div class="field">
                <div class="label">🕐 Received:</div>
                <div class="value">{{ $contact->created_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            
            @if($contact->ip_address)
            <div class="field">
                <div class="label">🌐 IP Address:</div>
                <div class="value">{{ $contact->ip_address }}</div>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p style="margin: 0;">This email was sent from your website contact form</p>
            <p style="margin: 10px 0 0 0;">Please reply directly to this email to respond to {{ $contact->name }}</p>
        </div>
    </div>
</body>
</html>
