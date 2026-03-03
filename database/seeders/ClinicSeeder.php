<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\MedicineStock;
use App\Models\Inspection;
use App\Models\Bill;
use App\Models\BillItem;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        // Doctors
        $doctors = [
            ['name' => 'Dr. Ramesh Gupta',    'specialization' => 'General Physician', 'phone' => '9876543210', 'qualification' => 'MBBS, MD', 'experience_years' => 15, 'consultation_fee' => 500, 'active' => true, 'schedule' => 'Mon-Sat: 9AM-5PM'],
            ['name' => 'Dr. Priya Shah',       'specialization' => 'Pediatrics',        'phone' => '9876543211', 'qualification' => 'MBBS, DCH', 'experience_years' => 10, 'consultation_fee' => 400, 'active' => true, 'schedule' => 'Mon-Fri: 10AM-4PM'],
            ['name' => 'Dr. Suresh Kumar',     'specialization' => 'Orthopedics',       'phone' => '9876543212', 'qualification' => 'MBBS, MS', 'experience_years' => 20, 'consultation_fee' => 700, 'active' => true, 'schedule' => 'Tue-Sun: 8AM-2PM'],
            ['name' => 'Dr. Anita Verma',      'specialization' => 'Dermatology',       'phone' => '9876543213', 'qualification' => 'MBBS, DVD', 'experience_years' => 8,  'consultation_fee' => 600, 'active' => true, 'schedule' => 'Mon-Sat: 11AM-6PM'],
            ['name' => 'Dr. Vikram Singhania', 'specialization' => 'Cardiology',        'phone' => '9876543214', 'qualification' => 'MBBS, DM', 'experience_years' => 25, 'consultation_fee' => 1000, 'active' => true, 'schedule' => 'Mon-Fri: 9AM-1PM'],
        ];
        foreach ($doctors as $d) Doctor::create($d);

        // Nurses
        $nurses = [
            ['name' => 'Nurse Sunita Patil',   'phone' => '9876500001', 'shift' => 'Morning', 'department' => 'General', 'active' => true, 'permissions' => ['view_patients', 'vitals']],
            ['name' => 'Nurse Kavita Sharma',  'phone' => '9876500002', 'shift' => 'Evening', 'department' => 'Pediatrics', 'active' => true, 'permissions' => ['view_patients', 'vitals', 'create_inspection']],
            ['name' => 'Nurse Rekha Singh',    'phone' => '9876500003', 'shift' => 'Night',   'department' => 'Emergency', 'active' => true, 'permissions' => ['view_patients']],
        ];
        foreach ($nurses as $n) Nurse::create($n);

        // Medicines
        $medicines = [
            ['name' => 'Paracetamol 500mg', 'generic_name' => 'Acetaminophen', 'category' => 'Tablet', 'manufacturer' => 'Cipla', 'unit_price' => 2.50, 'unit' => 'Strip', 'side_effects' => 'Nausea, liver damage in overdose', 'requires_prescription' => false],
            ['name' => 'Amoxicillin 250mg', 'generic_name' => 'Amoxicillin',   'category' => 'Capsule', 'manufacturer' => 'Sun Pharma', 'unit_price' => 12.00, 'unit' => 'Strip', 'side_effects' => 'Diarrhea, allergic reactions', 'requires_prescription' => true],
            ['name' => 'Cough Syrup 100ml', 'generic_name' => 'Dextromethorphan', 'category' => 'Syrup', 'manufacturer' => 'Himalaya', 'unit_price' => 85.00, 'unit' => 'Bottle', 'side_effects' => 'Drowsiness', 'requires_prescription' => false],
            ['name' => 'Omeprazole 20mg',   'generic_name' => 'Omeprazole',    'category' => 'Capsule', 'manufacturer' => 'Dr. Reddys', 'unit_price' => 8.00, 'unit' => 'Strip', 'side_effects' => 'Headache, diarrhea', 'requires_prescription' => true],
            ['name' => 'Metformin 500mg',   'generic_name' => 'Metformin HCl', 'category' => 'Tablet', 'manufacturer' => 'Lupin', 'unit_price' => 5.00, 'unit' => 'Strip', 'side_effects' => 'Nausea, diarrhea', 'requires_prescription' => true],
            ['name' => 'Atorvastatin 10mg', 'generic_name' => 'Atorvastatin',  'category' => 'Tablet', 'manufacturer' => 'Pfizer', 'unit_price' => 15.00, 'unit' => 'Strip', 'side_effects' => 'Muscle pain', 'requires_prescription' => true],
            ['name' => 'Betadine Cream',    'generic_name' => 'Povidone Iodine', 'category' => 'Cream', 'manufacturer' => 'Win-Medicare', 'unit_price' => 55.00, 'unit' => 'Tube', 'side_effects' => 'Skin irritation', 'requires_prescription' => false],
            ['name' => 'Azithromycin 500mg','generic_name' => 'Azithromycin',  'category' => 'Tablet', 'manufacturer' => 'Cipla', 'unit_price' => 18.00, 'unit' => 'Strip', 'side_effects' => 'Nausea, vomiting', 'requires_prescription' => true],
            ['name' => 'Insulin Regular',   'generic_name' => 'Insulin',       'category' => 'Injection', 'manufacturer' => 'Novo Nordisk', 'unit_price' => 120.00, 'unit' => 'Vial', 'side_effects' => 'Hypoglycemia', 'requires_prescription' => true],
            ['name' => 'Salbutamol Inhaler','generic_name' => 'Salbutamol',    'category' => 'Inhaler', 'manufacturer' => 'GSK', 'unit_price' => 180.00, 'unit' => 'Box', 'side_effects' => 'Tremors, palpitations', 'requires_prescription' => true],
        ];

        foreach ($medicines as $med) {
            $m = Medicine::create($med);
            MedicineStock::create([
                'medicine_id'   => $m->id,
                'quantity'      => rand(5, 100),
                'reorder_level' => 10,
                'expiry_date'   => now()->addMonths(rand(6, 24)),
                'batch_number'  => 'BATCH-' . rand(1000, 9999),
                'purchase_price'=> $m->unit_price * 0.7,
                'supplier'      => ['MedPlus', 'Apollo Pharmacy', 'Reliance Health', 'Health Unlimited'][rand(0, 3)],
            ]);
        }

        // Patients
        $patientData = [
            ['name' => 'Rajesh Kumar',    'age' => 45, 'gender' => 'Male',   'phone' => '9800000001', 'blood_group' => 'B+', 'chronic_diseases' => 'Diabetes Type 2, Hypertension'],
            ['name' => 'Priya Sharma',    'age' => 32, 'gender' => 'Female', 'phone' => '9800000002', 'blood_group' => 'O+', 'allergies' => 'Penicillin'],
            ['name' => 'Amit Patel',      'age' => 58, 'gender' => 'Male',   'phone' => '9800000003', 'blood_group' => 'A+', 'chronic_diseases' => 'Cardiac issues'],
            ['name' => 'Sunita Verma',    'age' => 28, 'gender' => 'Female', 'phone' => '9800000004', 'blood_group' => 'AB+'],
            ['name' => 'Vivek Singh',     'age' => 40, 'gender' => 'Male',   'phone' => '9800000005', 'blood_group' => 'A-'],
            ['name' => 'Meena Joshi',     'age' => 35, 'gender' => 'Female', 'phone' => '9800000006', 'blood_group' => 'B-', 'allergies' => 'Aspirin'],
            ['name' => 'Arun Gupta',      'age' => 62, 'gender' => 'Male',   'phone' => '9800000007', 'blood_group' => 'O-', 'chronic_diseases' => 'Arthritis, Diabetes'],
            ['name' => 'Kavitha Reddy',   'age' => 25, 'gender' => 'Female', 'phone' => '9800000008', 'blood_group' => 'O+'],
            ['name' => 'Suresh Nair',     'age' => 50, 'gender' => 'Male',   'phone' => '9800000009', 'blood_group' => 'B+', 'chronic_diseases' => 'Asthma'],
            ['name' => 'Divya Menon',     'age' => 18, 'gender' => 'Female', 'phone' => '9800000010', 'blood_group' => 'A+'],
            ['name' => 'Manoj Tiwari',    'age' => 47, 'gender' => 'Male',   'phone' => '9800000011', 'blood_group' => 'AB-'],
            ['name' => 'Rekha Agarwal',   'age' => 38, 'gender' => 'Female', 'phone' => '9800000012', 'blood_group' => 'O+'],
            ['name' => 'Deepak Malhotra', 'age' => 55, 'gender' => 'Male',   'phone' => '9800000013', 'blood_group' => 'B+', 'chronic_diseases' => 'Hypertension'],
            ['name' => 'Anita Kapoor',    'age' => 43, 'gender' => 'Female', 'phone' => '9800000014', 'blood_group' => 'A+'],
            ['name' => 'Rahul Bose',      'age' => 30, 'gender' => 'Male',   'phone' => '9800000015', 'blood_group' => 'O-'],
        ];

        $doctors = Doctor::all();
        $medicines = Medicine::all();

        foreach ($patientData as $pd) {
            $pd['patient_id'] = 'PAT-' . strtoupper(substr(str_replace(' ', '', $pd['name']), 0, 3)) . rand(1000, 9999);
            $patient = Patient::create($pd);

            // Multiple inspections per patient
            $inspectionCount = rand(1, 4);
            for ($i = 0; $i < $inspectionCount; $i++) {
                $doctor = $doctors->random();
                $inspection = Inspection::create([
                    'patient_id'      => $patient->id,
                    'doctor_id'       => $doctor->id,
                    'inspection_date' => now()->subDays(rand(1, 180)),
                    'chief_complaint' => ['Fever and headache', 'Stomach pain', 'Back pain', 'Cough and cold', 'Skin rash', 'Chest pain', 'Knee pain'][rand(0, 6)],
                    'diagnosis'       => ['Viral fever', 'Gastritis', 'Lumbar spondylosis', 'Upper respiratory infection', 'Allergic dermatitis', 'Hypertension', 'Osteoarthritis'][rand(0, 6)],
                    'vitals_bp'       => rand(110, 145) . '/' . rand(70, 95),
                    'vitals_temp'     => rand(97, 102) . '°F',
                    'vitals_pulse'    => rand(65, 95) . ' bpm',
                    'vitals_weight'   => rand(50, 90) . ' kg',
                    'notes'           => 'Patient advised rest and medication.',
                    'follow_up_date'  => now()->addDays(rand(7, 30)),
                ]);

                // Attach medicines to inspection
                $randMeds = $medicines->random(rand(1, 3));
                foreach ($randMeds as $med) {
                    $inspection->medicines()->attach($med->id, [
                        'dosage'   => ['1-0-1', '1-1-1', '0-0-1', '1-0-0'][rand(0, 3)],
                        'duration' => ['3 days', '5 days', '7 days', '10 days'][rand(0, 3)],
                        'quantity' => rand(1, 3),
                    ]);
                }

                // Create bill
                $billItems = [['description' => 'Consultation Fee', 'quantity' => 1, 'unit_price' => $doctor->consultation_fee, 'total' => $doctor->consultation_fee]];
                $subtotal = $doctor->consultation_fee;

                foreach ($randMeds as $med) {
                    $itemTotal = $med->unit_price * rand(1, 3);
                    $billItems[] = ['description' => $med->name, 'quantity' => rand(1, 3), 'unit_price' => $med->unit_price, 'total' => $itemTotal];
                    $subtotal += $itemTotal;
                }

                $bill = Bill::create([
                    'patient_id'     => $patient->id,
                    'doctor_id'      => $doctor->id,
                    'inspection_id'  => $inspection->id,
                    'bill_number'    => 'BILL-' . date('Ymd', strtotime('-' . rand(1, 180) . ' days')) . '-' . rand(100, 999),
                    'bill_date'      => $inspection->inspection_date,
                    'subtotal'       => $subtotal,
                    'discount'       => 0,
                    'total_amount'   => $subtotal,
                    'payment_status' => ['paid', 'paid', 'pending', 'paid'][rand(0, 3)],
                    'payment_method' => ['Cash', 'UPI', 'Card'][rand(0, 2)],
                ]);

                foreach ($billItems as $item) {
                    BillItem::create(array_merge($item, ['bill_id' => $bill->id]));
                }
            }
        }
    }
}