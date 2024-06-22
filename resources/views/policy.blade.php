@extends('layout')
@section('title')
    | Privacy Policies
@endsection
@section('header')
    <meta name="description" content="Welcome to Bfokus! We are committed to protecting your privacy">
@endsection
@section('content')
    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center py-5" tabindex="-1" >
        <div class="d-flex justify-content-start">
            <h1 class="text-white">Privacy Policy</h1>
        </div>
        <div class="d-grid justify-content-center text-white">
            <p>
                Welcome to Bfokus! We are committed to protecting your privacy and ensuring that your personal information is handled safely and responsibly. This privacy policy outlines how we collect, use, and protect your data when you use our service, located at https://bfokus.de).</a>.
            </p>
            <h2>1. Information We Collect</h2>
            <p>
                <ul>
                    <li>
                        <strong>Personal Data:</strong> When you use Bfokus, we may collect personal information such as your name, email address, and any other information you provide to us during registration or through the use of our service.
                    </li>
                    <li>
                        <strong>Usage Data:</strong>We may also collect data on how you access and use our service. This includes information such as your device’s IP address, browser type, operating system, pages visited, and the time and date of your visit.
                    </li>
                </ul>
            </p>

            <h2>2. Use of Information</h2>
            <p>
                <ul>
                    <li>
                        <strong>Service Provision:</strong> The information we collect is used to provide and improve our service. This includes facilitating voice search for products on Amazon, processing transactions, and providing customer support.
                    </li>
                    <li>
                        <strong>Personalization:</strong> We may use your data to personalize your experience, such as by providing product recommendations and enhancing the accessibility features of our service.
                    </li>
                    <li>
                        <strong>Compliance and Legal Obligations:</strong> We may use your data to personalize your experience, such as by providing product recommendations and enhancing the accessibility features of our service.
                    </li>
                </ul>
            </p>

            <h2>3. Data Protection and Security</h2>
            <p>
            <ul>
                <li>
                    <strong>Amazon Compliance:</strong> Bfokus ensures that all personal data is handled in accordance with Amazon’s Data Protection Policy. This includes implementing security measures to protect your information from unauthorized access, use, or disclosure.
                </li>
                <li>
                    <strong>Security Measures:</strong> We use industry-standard security protocols and technologies to safeguard your data. This includes encryption, secure storage solutions, and regular security audits.
                </li>
            </ul>
            </p>

            <h2>4. Sharing of Information</h2>
            <p>
            <ul>
                <li>
                    <strong>Third-Party Services:</strong> Bfokus uses Amazon’s API to provide product search and order functionalities. While using our service, your data may be shared with Amazon as necessary to complete these operations. We ensure that any data shared is handled in accordance with Amazon’s privacy policies.
                </li>
                <li>
                    <strong>Legal Requirements:</strong> We may disclose your information if required by law or in response to valid requests by public authorities.
                </li>
            </ul>
            </p>

            <h2>5. User Rights</h2>
            <p>
            <ul>
                <li>
                    <strong>Access and Control:</strong> You have the right to access, update, or delete your personal information. You can manage your data by contacting us at [Your Contact Information].
                </li>
                <li>
                    <strong>Consent Withdrawal:</strong> If you have given consent for data processing, you have the right to withdraw it at any time. This will not affect the lawfulness of processing based on consent before its withdrawal.
                </li>
            </ul>
            </p>


            <h2>6. Changes to This Privacy Policy</h2>
            <p>We may update this privacy policy from time to time. When we make changes, we will revise the effective date at the bottom of this page. We encourage you to review this policy periodically to stay informed about how we are protecting your data.</p>

            <h2>7. Contact Us</h2>
            <p>If you have any questions or concerns about this privacy policy or our data practices, please contact us at bfokus@gmail.com</p>

            <p>Effective Date: 2024-06-22</p>
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
