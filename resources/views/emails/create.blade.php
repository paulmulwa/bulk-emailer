@extends('layouts.app')

@section('content')
    <h2>Send Bulk Emails</h2>

    <form id="emailForm" action="{{ route('emails.sendBulk') }}" method="POST">
        @csrf
        <input type="text" name="subject" class="form-control mb-3" placeholder="Email Subject" required>
        <textarea id="message" name="message" class="form-control" rows="15" placeholder="Enter your message. Use {FirstName} to personalize." required></textarea>
        <button type="submit" class="btn btn-success">Send Emails</button>
    </form>
    <h3 class="mt-4">Uploaded Emails</h3>
    <table class="table table-bordered">
        <thead>
            <tr><th>First Name</th><th>Email</th></tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
                <tr><td>{{ $email->first_name }}</td><td>{{ $email->email }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.1/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: '#message',
            menubar: true, // Enable the full menu bar
            plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality emoticons template paste textpattern imagetools',
            toolbar1: 'undo redo | formatselect fontselect fontsizeselect | bold italic underline strikethrough forecolor backcolor',
            toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code fullscreen',
            toolbar3: 'table emoticons hr pagebreak anchor spellchecker',
            height: 500, // Increased height
            width: '100%', // Full width
            branding: false, // Removes TinyMCE branding
            image_uploadtab: true, // Enables image upload tab
            images_upload_url: '/upload-image', // Backend route for image uploads
            automatic_uploads: true, // Automatically upload images when selected
            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        callback(reader.result, {alt: file.name});
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
            setup: function(editor) {
        editor.on('change', function() {
            tinymce.triggerSave(); // Ensures TinyMCE content is passed to the form
        });

        editor.on('init', function() {
            console.log("TinyMCE Initialized!");
        });
    }
});

document.getElementById('emailForm').addEventListener('submit', function(event) {
tinymce.triggerSave();
var messageContent = document.getElementById('message').value;
console.log("Form submitted! Message Content: ", messageContent);
});



    </script>
@endsection
