<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>

	<button type="button" class="btn btn-primary" onclick="install_provinces();">
		ติดตั้ง จังหวัด อำเภอ ตำบล
	</button>

    <form id="uploadForm">
	    <input type="file" id="excelFile" accept=".xlsx, .xls" />
	    <button type="submit">Upload</button>
	</form>

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

		        const apiUrl = `{{ url('/') }}/api/excel_add_districts`;
		        // const apiUrl = `{{ url('/') }}/api/excel_add_sub_districts`;

		        const formData = new FormData();
		        formData.append("file", file);

		        // ทำการดึง CSRF Token หลังจาก DOM โหลดเสร็จ
		        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

		        try {
		            const response = await fetch(apiUrl, {
		                method: "POST",
		                headers: {
		                    "X-CSRF-TOKEN": csrfToken, // ใช้ CSRF Token ที่ได้
		                },
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

		function install_provinces(){
			fetch("{{ url('/') }}/api/install_provinces")
	            .then(response => response.text())
	            .then(provinces => {
	                console.log(provinces);

	                if(provinces == "provinces OK"){
	                	fetch("{{ url('/') }}/api/install_districts")
				            .then(response => response.text())
				            .then(districts => {
				                console.log(districts);

				                if(districts == "districts OK"){
				                	fetch("{{ url('/') }}/api/install_sub_districts")
							            .then(response => response.text())
							            .then(sub_districts => {
							                console.log(sub_districts);
							        });
				                }
				        });
	                }
	        });
		}

    </script>
</body>
</html>
