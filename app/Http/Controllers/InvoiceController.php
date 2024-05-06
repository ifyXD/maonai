<?php

namespace App\Http\Controllers;
use App\Models\Labor;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\Contact; // Import the Contact model
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;


class InvoiceController extends Controller


{
    /**
 * Display the labors associated with the specified contact,
 * along with the overall total amount.
 *
 * @param  int  $contact_id
 * @return \Illuminate\Http\Response
 */
public function index($contact_id)
{
    // Retrieve the contact
    $contact = Contact::findOrFail($contact_id);

    // Retrieve labors associated with the contact
    $labors = $contact->labors;

    // Retrieve materials associated with the contact
    $materials = $contact->materials;

    // Calculate total amount for labors
    $totalLaborAmount = $this->getTotalLaborAmount($labors);

    // Calculate total amount for materials
    $totalMaterialAmount = $this->getTotalMaterialAmount($materials);

    // Calculate overall total amount
    $overallTotalAmount = $totalLaborAmount + $totalMaterialAmount;

    // Pass $contact, $labors, $materials, and total amounts to the view
    return view('invoices.index', compact('contact', 'labors', 'materials', 'totalLaborAmount', 'totalMaterialAmount', 'overallTotalAmount'));
}

// Method to calculate total amount for labors
private function getTotalLaborAmount($labors)
{
    // Initialize total labor amount
    $totalLaborAmount = 0;

    // Loop through labors and sum up amounts
    foreach ($labors as $labor) {
        $totalLaborAmount += $labor->amount;
    }

    return $totalLaborAmount;
}

// Method to calculate total amount for materials
private function getTotalMaterialAmount($materials)
{
    // Initialize total material amount
    $totalMaterialAmount = 0;

    // Loop through materials and sum up amounts
    foreach ($materials as $material) {
        $totalMaterialAmount += $material->amount;
    }

    return $totalMaterialAmount;
}


    // Display the form to add a new labor record
    public function createLabors($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        return view('invoices.createLabors', compact('contact'));
    }

    /**
     * Store multiple labor records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $contact_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLabors(Request $request, $contact_id)
    {
        $request->validate([
            'name.*' => 'required|string|max:255',
            'date.*' => 'required|date',
            'rate.*' => 'required|numeric|min:0',
            'hours.*' => 'required|numeric|min:0',
        ]);

        $laborsData = [];

        // Iterate through each labor record
        foreach ($request->input('name') as $key => $value) {
            $rate = $request->input('rate')[$key];
            $hours = $request->input('hours')[$key];

            // Calculate the amount
            $amount = $rate * $hours;

            $laborsData[] = [
                'name' => $request->input('name')[$key],
                'date' => $request->input('date')[$key],
                'rate' => $rate,
                'hours' => $hours,
                'amount' => $amount, // Assign the calculated amount
                'contact_id' => $contact_id,
            ];
        }

        // Insert multiple labor records
        Labor::insert($laborsData);

        return redirect()->route('invoices.index', ['contact_id' => $contact_id])->with('success', 'Labors added successfully');
    }


    /**
     * Display the form to add materials.
     *
     * @param  int  $contact_id The ID of the contact associated with the materials.
     * @return \Illuminate\Contracts\View\View
     */
    public function createMaterials($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        return view('invoices.createMaterials', compact('contact'));
    }


    /**
     * Store a new material record.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request containing material data.
     * @param  int  $contact_id The ID of the contact associated with the materials.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMaterials(Request $request, $contact_id)
    {
        $request->validate([
            'date' => 'required|date',
            'material' => 'required|string',
            'quantity' => 'required|numeric|min:0.01', // Ensure quantity is a numeric value greater than or equal to 0.01 (minimum allowed value for a decimal)
            'unit_cost' => 'required|numeric|min:0.01', // Ensure unit_cost is a numeric value greater than or equal to 0.01 (minimum allowed value for a decimal)
        ]);

        // Create a new material record
        $material = new Material();
        $material->material = $request->input('material');
        $material->date = $request->input('date');
        $material->quantity = $request->input('quantity');
        $material->unit_cost = $request->input('unit_cost');
        $material->amount = $request->input('quantity') * $request->input('unit_cost');
        $material->contact_id = $contact_id;
        $material->save();

        return redirect()->route('invoices.index', ['contact_id' => $contact_id])->with('success', 'Material added successfully');
    }



    /**
 * Generate a PDF invoice for the specified contact.
 *
 * @param  int  $contact_id The ID of the contact for which to generate the PDF invoice.
 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The PDF file as a download.
 */
public function generatePDF($contact_id)
{
    // Retrieve the contact and related labors and materials
    $contact = Contact::findOrFail($contact_id);
    $labors = $contact->labors;
    $materials = $contact->materials;

    // Calculate total amount for labors
    $totalLaborAmount = $this->getTotalLaborAmountPDF($labors);

    // Calculate total amount for materials
    $totalMaterialAmount = $this->getTotalMaterialAmountPDF($materials);

    // Calculate overall total amount
    $overallTotalAmount = $totalLaborAmount + $totalMaterialAmount;

    // Default date
    $defaultDate = Carbon::now()->toDateString(); // Current date

    // Consolidate the data under a single identifier
    $invoiceData = [
        'contact' => $contact,
        'labors' => $labors,
        'materials' => $materials,
        'numLabors' => $labors->count(),
        'numMaterials' => $materials->count(),
        'defaultDate' => $defaultDate, // Pass default date to view
        'totalLaborAmount' => $totalLaborAmount, // Pass total labor amount to view
        'totalMaterialAmount' => $totalMaterialAmount, // Pass total material amount to view
        'overallTotalAmount' => $overallTotalAmount, // Pass overall total amount to view
    ];

    // Define the file name with the contact ID
    $fileName = 'GSOinvoice-' . $contact->id . '.pdf';

    // Load the view into a variable
    $pdf = PDF::loadView('invoices.printPDF', compact('invoiceData'));

    // Return the PDF as a download with the specified file name
    return $pdf->download($fileName);
}

// Method to calculate total amount for labors in generatePDF method
private function getTotalLaborAmountPDF($labors)
{
    // Initialize total labor amount
    $totalLaborAmount = 0;

    // Loop through labors and sum up amounts
    foreach ($labors as $labor) {
        $totalLaborAmount += $labor->amount;
    }

    return $totalLaborAmount;
}

// Method to calculate total amount for materials in generatePDF method
private function getTotalMaterialAmountPDF($materials)
{
    // Initialize total material amount
    $totalMaterialAmount = 0;

    // Loop through materials and sum up amounts
    foreach ($materials as $material) {
        $totalMaterialAmount += $material->amount;
    }

    return $totalMaterialAmount;
}








}
