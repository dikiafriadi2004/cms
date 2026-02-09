<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Reply - Simple Test</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .ql-container { min-height: 300px; }
        .ql-editor { min-height: 300px; }
        button { margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Contact Reply - Simple Test</h1>
    <p>Contact: {{ $contact->name }} ({{ $contact->email }})</p>
    
    <form method="POST" action="{{ route('admin.contacts.send-reply', $contact) }}" id="reply-form">
        @csrf
        <div>
            <label>Subject:</label><br>
            <input type="text" name="subject" value="Re: {{ $contact->subject }}" style="width: 100%; padding: 8px;">
        </div>
        <br>
        <div>
            <label>Message:</label><br>
            <div id="editor"></div>
            <textarea name="message" id="message" style="display:none;"></textarea>
        </div>
        <button type="submit">Send Reply</button>
    </form>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ]
        }
    });

    document.getElementById('reply-form').addEventListener('submit', function(e) {
        var html = quill.root.innerHTML;
        var text = quill.getText().trim();
        document.getElementById('message').value = html;
        if (!text) {
            e.preventDefault();
            alert('Pesan tidak boleh kosong!');
            return false;
        }
    });
    </script>
</body>
</html>
