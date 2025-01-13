@extends('layouts.theme_admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <form id="uploadForm">
                    <input type="file" id="excelFile" accept=".xlsx, .xls" />
                    <button class="btn btn-sm btn-info" type="submit">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("uploadForm").addEventListener("submit", async (e) => {
                e.preventDefault();

                const fileInput = document.getElementById("excelFile");
                const file = fileInput.files[0];

                if (!file) {
                    alert("Please select an Excel file.");
                    return;
                }

                const apiUrl = `{{ url('/') }}/api/excel_add_polling_units`;

                const formData = new FormData();
                formData.append("file", file);

                try {
                    const response = await fetch(apiUrl, {
                        method: "POST",
                        body: formData,
                    });

                    if (!response.ok) {
                        throw new Error(`Error: ${response.statusText}`);
                    }

                    const result = await response.json();
                    console.log("API Response:", result);
                } catch (error) {
                    console.error("Error:", error);
                }
            });
        });

    </script>
@endsection
