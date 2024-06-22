@extends('layout')
@section('title')
    | Terms and Conditions
@endsection
@section('header')
    <meta name="description" content="These (obligatory-to-accept) terms and conditions outline the rules and regulations for the use of Bfokus.">
@endsection
@section('content')
    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center py-5" tabindex="-1" >
        <div class="d-flex justify-content-start">
            <h1 class="text-white">Terms & Conditions</h1>
        </div>
        <div class="d-grid justify-content-center text-white">
            <h2>Welcome to Bfokus!</h2>
            <p>
                These terms and conditions outline the rules and regulations for the use of Bfokus, applications, and website, located at https://bfokus.de.
                By accessing this Website and Application, you accept these terms and conditions. Do not continue to use Bfokus if you do not agree to all of the terms and conditions stated on this page. Also, we have a Privacy Policy that you can read by clicking this
                <a href="/policy">link</a>.
            </p>
            <h2>1. Use of the Service</h2>
            <p>The service is intended to assist blind and visually impaired individuals in finding and ordering products on Amazon. Users must provide accurate information and use the service responsibly.</p>
            <h2>2. Disclaimer</h2>
            <p>Bfokus provides the service "as is" and does not guarantee the accuracy, reliability, or availability of the service. We are not responsible for any errors or omissions nor for any outcomes resulting from the use of our service, including but not limited to ordering incorrect items.</p>

            <h2>3. Limitation of Liability</h2>
            <p>
                <ul>
                    <li><strong>Accuracy of Information:</strong> Bfokus does not guarantee the accuracy, completeness, or reliability of the information provided through our service. The details of the products, including descriptions, prices, and availability, are sourced from Amazon and may change without notice.</li>
                    <li><strong>User Responsibility:</strong>Users are responsible for verifying the accuracy of their orders before completion. This includes but is not limited to, checking product details, quantities, prices, and shipping information. Bfokus is not liable for any incorrect orders, data inaccuracies, or any other issues arising from the use of the service.</li>
                    <li><strong>No Warranty:</strong>The service is provided on an "as is" and "as available" basis. Bfokus disclaims all warranties, whether express or implied, including but not limited to the implied warranties of merchantability, fitness for a particular purpose, and non-infringement. We do not warrant that the service will be uninterrupted, timely, secure, or error-free.</li>
                    <li><strong>Limitation of Liability:</strong>To the fullest extent permitted by law, Bfokus shall not be liable for any direct, indirect, incidental, special, consequential, or punitive damages arising out of or in connection with the use of the service. This includes, but is not limited to, damages for loss of profits, goodwill, use, data, or other intangible losses.</li>
                    <li><strong>Third-Party Services:</strong>Bfokus utilizes Amazon’s API to provide product search and order assistance. We are not responsible for any actions or policies of Amazon or any other third party. Any issues related to products, transactions, or services provided by Amazon must be addressed directly with Amazon.</li>
                    <li><strong>Indemnification:</strong>Users agree to indemnify and hold Bfokus, its affiliates, officers, agents, and employees, harmless from any claim or demand, including reasonable attorneys' fees, made by any third party due to or arising out of the user’s violation of these terms and conditions or their infringement of any rights of another.</li>
                </ul>
            </p>

            <h2>4. User Responsibilities</h2>
            <p>Users are responsible for ensuring the accuracy of the information they provide, the search results provided by the service, and for the consequences of their actions while using the service. Misuse of the service, including providing false or misleading information, is prohibited.
                <strong>Age Limits:</strong> Our Services are for use by adults 18 and older.
            </p>
            <h2>5. Privacy</h2>
            <p>We are committed to protecting your privacy. Please review our Privacy Policy, which also governs your visit to our website and use of the application, to understand our practices.</p>
            <h2>6. Termination</h2>
            <p>We reserve the right to suspend or terminate your access to the service at any time, without notice, for conduct that we believe violates these terms and conditions or is otherwise harmful to other users of the service, us, or third parties, or for any other reason.</p>
            <h2>7. Changes to Terms</h2>
            <p>We may update these terms and conditions from time to time. When we do, we will revise the updated date at the bottom of this page. We encourage users to frequently check this page for any changes to stay informed about our terms and conditions.</p>
            <h2>8. Contact Us</h2>
            <p>If you have any questions about these terms and conditions, please contact us at bfokus@gmail.com
                Effective Date: 2024-06-22
            </p>
            <button onclick="acceptTerm()" class="more-page btn ">Accept and Use App</button>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function acceptTerm(){
            $.ajax({
                url: "/accept-term",
                type: "Get",

                success: function (data) {
                    window.location.href = '/'
                },
                error: function (data) {
                    console.log(data)
                }
            });
        }
    </script>
@endsection
