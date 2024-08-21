<x-layout title="Card Example">
    <x-slot name="header">
        <h1>Card Example Page</h1>
    </x-slot>

    <x-slot name="body">
        <div class="card">
            <div class="card-header">
                Card Title
            </div>
            <div class="card-body">
                <p>This is a simple card body. You can include text, images, or other elements here.</p>
                <a href="#" class="btn btn-primary">Learn More</a>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <p>&copy; {{ date('Y') }} My Application. All rights reserved.</p>
    </x-slot>
</x-layout>

<style>
   /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #f4f4f4;
}

/* Header Styles */
.header {
    background-color: #007bff;
    color: #fff;
    padding: 1rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Main Content Styles */
.main {
    padding: 2rem;
    max-width: 1200px;
    margin: auto;
}

/* Card Body Styles */
.card {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
    padding: 1.5rem;
}

.card-header {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.card-body {
    font-size: 1rem;
    color: #333;
}

/* Footer Styles */
.footer {
    background-color: #343a40;
    color: #fff;
    padding: 1rem;
    text-align: center;
    position: fixed;
    width: 100%;
    bottom: 0;
}

/* Button Styles */
.btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0.5rem;
    text-decoration: none;
    border-radius: 0.25rem;
    color: #fff;
    font-size: 1rem;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
}


</style>
