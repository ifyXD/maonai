

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">

    <style>
        body {
            background-color: #353535;
        }
        .green-yellow-gradient {
            background: linear-gradient(to right, #227A0C, #82AD34);
        }
        .smaller-header {
            font-size: 1.5rem;
        }
        .light-green-border {
            border-color: #d4edda; /* Light green color */
        }

            /* Define the border color for the labors card */
        .labors-card {
            border-color: #353535 !important; /* Use the green color you desire */
        }

        .invoice-card {
            border-color: #353535 !important; /* Use the green color you desire */
        }

        .materials-card {
            border-color: #353535 !important; /* Use the green color you desire */
        }




    </style>
</head>
<body>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <!-- Main page content-->
            <div class="container mt-4">
                <div class="container">

                    <!-- Invoice Profile -->
                    <div class="card mb-4 invoice-card">
                        <div class="card-header p-4 p-md-5 border-bottom-0 green-yellow-gradient text-white light-green-border">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                                    <h2 class="text-white mb-0">
                                        <i data-feather="save" style="font-size: 1.5em; vertical-align: middle;"></i> <!-- Adjust the font-size as needed -->
                                        Invoice Profile:
                                    </h2>


                                </div>
                                <div class="col-12 col-lg-auto text-center text-lg-right">
                                    <!-- Invoice details-->
                                    <div class="h3 text-white">
                                        <i data-feather="user" style="font-size: 1.5em;"></i> <!-- Adjust the font-size as needed -->
                                        {{ $contact->name }}
                                    </div>

                                    #00{{ $contact->id }}
                                    <br />
                                    January 1, 2020
                                </div>
                            </div>
                        </div>
                        <!-- Invoice content -->
                        <div class="card-body p-4 p-md-5">
                            <div class="row">
                                <!-- Right column for additional options -->
                                <div class="col-md-4 d-flex justify-content-end align-items-center">
                                    <div class="text-center d-flex flex-column align-items-start" style="width: 100%;"> <!-- Set width for the container -->

                                        <!-- Option 1: Contact Dashboard -->
                                        <div class="mb-2 option-container d-flex align-items-center">
                                            <!-- Button for Contact Dashboard -->
                                            <a href="/contacts" class="btn btn-success rounded-circle mr-2" title="Go to Contact Dashboard" style="width: 60px; height: 60px; display: flex; justify-content: center; align-items: center;">
                                                <i data-feather="home" class="fs-4"></i>
                                            </a>
                                            <!-- Label for Contact Dashboard -->
                                            <p class="mb-0"><strong><em>|Contact Main</em></strong></p>
                                        </div>


                                            <!-- Option 2: Print to PDF -->
                                        <div class="mb-2 option-container d-flex align-items-center">
                                            <!-- Button for printing to PDF -->
                                            <button class="btn btn-danger rounded-circle mr-2" id="print-pdf-button" title="Print to PDF" style="width: 60px; height: 60px;"> <!-- Adjust width and height -->
                                                <i data-feather="printer" class="fs-4"></i> <!-- Replace "printer" with your chosen icon name, and fs-4 class to make it larger -->
                                            </button>
                                            <!-- Label for printing to PDF -->
                                            <p class="mb-0"><strong><em>|Print to PDF</em></strong></p>

                                        </div>

                                        <div class="mb-2 option-container d-flex align-items-center">
                                            <!-- Button for exporting to Word -->
                                            <a href="{{ route('invoices.generateWord', ['contact_id' => $contact->id]) }}" class="btn btn-primary rounded-circle mr-2" id="print-word-button" title="Export to Word" style="width: 60px; height: 60px; display: flex; justify-content: center; align-items: center;">
                                                <!-- Icon for Word export -->
                                                <i data-feather="file-text" class="fs-4"></i>
                                            </a>
                                            <!-- Label for exporting to Word -->
                                            <p class="mb-0"><strong><em>|Export to Word</em></strong></p>
                                        </div>



                                    </div>
                                </div>

                                        <!-- Left column for contact details -->
                                <div class="col-md-4 position-relative">
                                    <!-- Left border line -->
                                    <div class="position-absolute top-0 bottom-0 start-0 border-end border-dark"></div>
                                    <div class="row border-bottom py-2">
                                        <div class="col-md-12">
                                            <p><strong>Email:</strong> {{ $contact->email }}</p>
                                        </div>
                                    </div>
                                    <div class="row border-bottom py-2">
                                        <div class="col-md-12">
                                            <p><strong>Department:</strong> {{ $contact->department }}</p>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-12">
                                            <p><strong>Content:</strong></p>
                                            <p class="font-weight-bold small text-muted d-none d-md-block">: "{{ $contact->content }}"</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Center column for labor and material details -->
                                <div class="col-md-4 border-start border-end py-4">
                                    <div class="text-center">
                                        <p><strong>Labors:</strong> ₱{{ $totalLaborAmount }}</p>
                                        <p><strong>Materials:</strong> ₱{{ $totalMaterialAmount }}</p>
                                        <p><strong>Total Amount:</strong> ₱{{ $overallTotalAmount }}</p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>








                                    <!-- Labors Needed -->
                    <div class="card mb-4 labors-card">
                        <div class="card-header p-4 p-md-5 border-bottom-0 green-yellow-gradient text-white light-green-border">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                                    <h2 class="text-white mb-0">
                                        <i data-feather="users" style="font-size: 1.5em;"></i> <!-- Adjust the font-size as needed -->
                                        Labors Needed
                                    </h2>

                                    <p>Associated Manpower</p>
                                </div>
                                <div class="col-12 col-lg-auto text-center text-lg-right">
                                    <!-- Insert button for labors -->
                                    <a href="{{ route('invoices.createLabors', ['contact_id' => $contact->id]) }}" class="btn btn-primary">
                                        <i data-feather="plus-circle"></i> Insert New-Labor
                                    </a>
                                </div>

                            </div>
                        </div>
                        <!-- Invoice content -->
                        <div class="card-body p-4 p-md-5">
                            <!-- Invoice table -->
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <!-- Table headers -->
                                    <thead class="border-bottom">
                                        <tr class="small text-uppercase text-muted">
                                            <th scope="col">Description</th>
                                            <th class="text-center" scope="col">Hours</th>
                                            <th class="text-center" scope="col">Rate</th>
                                            <th class="text-center" scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody>
                                        <!-- Loop through each labor entry -->
                                        @foreach ($contact->labors as $labor)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="font-weight-bold">{{ $labor->name }}</div>
                                                <div class="small text-muted d-none d-md-block">{{ $labor->date }}</div>
                                            </td>
                                            <td class="text-center align-middle font-weight-bold">{{ $labor->hours }}</td>
                                            <td class="text-center align-middle font-weight-bold">₱{{ $labor->rate }}</td>
                                            <td class="text-center align-middle font-weight-bold">₱{{ $labor->amount }}</td>
                                        </tr>
                                        @endforeach

                                        <!-- Invoice total -->

                                        <tr>
                                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Total Amount Due:</div></td>
                                            <td class="text-center pb-0"><div class="h5 mb-0 font-weight-700">₱{{ $totalLaborAmount }}</div></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                                    <!-- Materials -->
                    <div class="card mb-4 materials-card">
                        <div class="card-header p-4 p-md-5 border-bottom-0 green-yellow-gradient text-white light-green-border">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                                    <h2 class="text-white mb-0">
                                        <i data-feather="archive" style="font-size: 1.5em; vertical-align: middle;"></i> <!-- Adjust the font-size as needed -->
                                        Materials:
                                    </h2>
                                    <p>Supplies & Hardware</p>
                                </div>
                                <div class="col-12 col-lg-auto text-center text-lg-right">
                                    <!-- Insert button for materials -->
                                    <a href="{{ route('invoices.createMaterials', ['contact_id' => $contact->id]) }}" class="btn btn-primary">
                                        <i data-feather="plus-circle"></i> Insert New-Material
                                    </a>
                                </div>

                            </div>
                        </div>
                        <!-- Invoice content -->
                        <div class="card-body p-4 p-md-5">
                            <!-- Invoice table -->
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <!-- Table headers -->
                                    <thead class="border-bottom">
                                        <tr class="small text-uppercase text-muted">
                                            <th scope="col">Description</th>
                                            <th class="text-center" scope="col">Quantity</th>
                                            <th class="text-center" scope="col">Unit Cost</th>
                                            <th class="text-center" scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody>
                                        <!-- Invoice items -->
                                        @foreach ($materials as $material)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="font-weight-bold">{{ $material->material }}</div>
                                                <div class="small text-muted d-none d-md-block">{{ $material->date }}</div>
                                            </td>
                                            <td class="text-center align-middle font-weight-bold">{{ $material->quantity }}</td>
                                            <td class="text-center align-middle font-weight-bold">₱{{ $material->unit_cost }}</td>
                                            <td class="text-center align-middle font-weight-bold">₱{{ $material->amount }}</td>
                                        </tr>
                                        @endforeach
                                        <!-- Invoice total -->

                                        <tr>
                                            <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Total Amount Due:</div></td>
                                            <td class="text-center pb-0"><div class="h5 mb-0 font-weight-700">₱{{ $totalMaterialAmount }}</div></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </main>
    </div>
</div>

<footer class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-3 mb-lg-0">
                <div class="footer-section">
                    <h6 class="text-uppercase mb-2">OFFICE:</h6>
                    <p class="mb-1">General Service Office</p>
                    <p class="mb-1">V362+285, Motorpool</p>
                    <p>Maramag, Bukidnon</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3 mb-lg-0">
                <div class="footer-section">
                    <h6 class="text-uppercase mb-2">From:</h6>
                    <p class="mb-1">Central Mindanao University</p>
                    <p class="mb-1">V362+285, </p>
                    <p>Maramag, Bukidnon</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="footer-section">
                    <h6 class="text-uppercase mb-2">Note:</h6>
                    <p class="mb-0">Payment is due 15 days after receipt of this invoice. Please make checks or money orders out to Company Name, and include the invoice number in the memo. We appreciate your business, and hope to be working with you again very soon!</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace(); // Initialize Feather icons
</script>

<script>
    // Attach a click event listener to the button
    document.getElementById('print-pdf-button').addEventListener('click', function() {
        // Make an AJAX request to the controller method
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '{{ route('invoices.generatePDF', ['contact_id' => $contact->id]) }}', true);
        xhr.responseType = 'blob'; // Set response type to blob
        xhr.onload = function() {
            // Create a blob URL from the response
            var blob = new Blob([xhr.response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            // Create a link element and trigger a click event to download the PDF
            var a = document.createElement('a');
            a.href = url;
            a.download = 'GSOinvoice-{{ $contact->id }}.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        };
        xhr.send();
    });
</script>






</body>
</html>
