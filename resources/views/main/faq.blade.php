@extends('layouts.main')

@section('add_css')
@endsection

@section('content')
    <div class="header header-image-2 pt-3">
        <div class="container">
            <div class="row">

                <div class="col-md-6 order-2 order-md-1">
                    <h1 class="mt-5 pt-5">Got Questions?</h1>

                    <p class="mt-4">
                        Car Flo is an innovative car sharing app and rental service for commercial drivers. You’ll need a valid driver’s license and a license from NYC’s Taxi and Limousine Commission (TLC). Once approved, you can rent our cars to start earning consistent money with rideshare. Car owners can earn additional money by renting their vehicles through Car Flo.
                </div>
            </div>

        </div>
    </div>


    <div class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-10 offset-1">

                    <div class="step">
                        <h5>What is Car Flo?</h5>
                        <p>
                            Car Flo ls is a Taxi & Limousine Commission vehicle sharing platform. We enable drivers who don’t own a vehicle to rent a quality rideshare-approved car for just the days and hours they wish to drive.
                        </p>
                        <p>
                            We also give car owners the ability to rent their vehicles to TLC-licensed drivers and significantly boost their income.
                        </p>
                    </div>

                    <div class="step">
                        <h5>As an owner, how much will my car rent for?</h5>
                        <p>
                            You set the rental rate for your vehicle. When you set your rate, remember that Car Flo charges a 20 percent commission.
                        </p>
                    </div>

                    <div class="step">
                        <h5>How do I get started as a driver?</h5>
                        <p>To <a href="{{url('/drivers#signup2')}}">register</a>, you’ll need to provide us with some basic information as well as snap pictures of the following documents and upload the photos to us:</p>
                        <ul>
                            <li>TLC License</li>
                            <li>DMV License</li>
                            <li>Proof of Address (ex: utility bill, bank statement)</li>
                            <li>Debit/Credit Card</li>
                        </ul>
                        <p>
                            We’ll get back to you within four hours to let you know if  you are approved. Once approved you can begin scheduling your rentals to match your desire to drive.
                        </p>
                    </div>

                    <div class="step">
                        <h5>How do I get started as an owner?</h5>
                        <p>To rent your vehicle we will need to collect some information as well as some pictures of the following documents:</p>
                        <ul>
                            <li>Car Make (Honda, Toyota…)</li>
                            <li>Car Model</li>
                            <li>Miles</li>
                            <li>Pickup and Drop-off Location</li>
                            <li>Your Vehicles Availability (Days of the week and hours)</li>
                            <li>Registration</li>
                            <li>Title</li>
                            <li>Diamond Sticker</li>
                            <li>FH-1 Insurance</li>
                            <li>Photos of Your Vehicle</li>
                            <li>Social Security Number (To issue 1099’s)</li>
                            <li>Account and Routing Number (To Send Your Earnings)</li>
                        </ul>
                    </div>

                    <div class="step">
                        <h5>Do I need to have my license for a certain period of time in order to rent a car?</h5>
                        <p>
                            We vet all of our drivers thoroughly to make sure they are responsible and trustworthy drivers. Drivers must have at least one year with their driver’s license in order to signup.
                        </p>
                    </div>
                    <div class="step">
                        <h5>How long does the process take to begin working with Car Flo?</h5>
                        <p>
                            Once you have submitted your documents within four hours. After your approval, it can take 24-48 hours to get you insured and ready to drive.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Can I drive a flexible schedule?</h5>
                        <p>
                            Absolutely. With the Car Flo app, you can schedule rentals for any hours on any days you want to work. If you want to work fulltime every day, go for it. If you want to earn extra money in your free time, you can easily schedule rentals for just those hours.
                        </p>
                    </div>
                    <div class="step">
                        <h5>How much advance notice do I need to give to reserve hours?</h5>
                        <p>
                            No advance notice is needed. Once you are approved by us simply choose and the app will automatically let you know which vehicles and times are available in your area.
                        </p>
                    </div>
                    <div class="step">
                        <h5>How do I get the vehicle on to my Uber account?</h5>
                        <p>
                            Don’t worry, shortly after you book a vehicle, the documents you need to add the vehicle to your rideshare account will be emailed to you.
                        </p>
                    </div>
                    <div class="step">
                        <h5>As a driver, do I need to carry my own insurance?</h5>
                        <p>
                            All <strong>Car Flo</strong> vehicles carry liability and collision insurance, as required by NYC TLC regulations. It is the responsibility of the driver to ensure that all requisite documents are accessible while driving the vehicle.
                        </p>
                    </div>
                    <div class="step">
                        <h5>What happens if there is damage during my rental?</h5>
                        <p>
                            For damage incurred during the time of your rental, you’ll be responsible for any deductible or repairs. Car Flo offers an umbrella policy available for purchase that will cover the deductible in case of damage. In cases of gross negligence, this policy is void.
                        </p>
                        <p>
                            When renting a car owned by a Car Flow Owner and made available to other drivers, you need to communicate with the owner. The Car Flo Owner will add your name to the car’s insurance policy.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Is there a cancellation fee?</h5>
                        <p>
                            There is no cancellation fee when canceling 24 hours in advanced. You will be charged 50% of your rental if you choose to cancel within 24 hours.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Do I need to be pre-approved from Uber/Via/Lyft?</h5>
                        <p>
                            Yes. Car Flo is a service for approved rideshare drivers.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Where can I drive the car? Do I have a specific mileage allotment?</h5>
                        <p>
                            You may drive the car in any of the five boroughs of New York City during your shift. There is unlimited mileage for these areas.
                        </p>
                    </div>
                    <div class="step">
                        <h5>What about tolls?</h5>
                        <p>
                            Drivers are responsible for providing an EZ pass when they are using a Car Flo vehicle.
                        </p>
                    </div>
                    <div class="step">
                        <h5>And Parking?</h5>
                        <p>
                            Each vehicle will have its own guidelines for parking that will be determined by the owner of the vehicle. Drivers will park the vehicle legally when the vehicle is rented. When drivers return the vehicle to the owner they will park it based on the vehicle owners instructions.
                        </p>
                    </div>
                    <div class="step">
                        <h5>What happens if I get a ticket?</h5>
                        <p>
                            Whoops! Can’t help you there. Drive safely and follow the rules of the road. You are responsible for any tickets you receive. The credit card on file will be charged for any parking fees that were a result of your parking. Any points for violations will go on you license.
                        </p>
                    </div>
                    <div class="step">
                        <h5>What if I get into an accident?</h5>
                        <p>
                            Call 9-1-1 to file a police report whenever you get into an accident. After calling 9-1-1, click the Car Is Damaged button on your app, upload photos of the damage and the police report. You are responsible to upload the police report to our app within five business days. We’ll walk you through the process from there.
                        </p>
                    </div>
                    <div class="step">
                        <h5>What do I do with the keys?</h5>
                        <p>
                            Simply hand off the keys to the next driver or make sure to return the ignition key to the designated area INSIDE the vehicle. There is up to a $1,000 penalty for not returning the keys to the vehicle.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Do I need to refuel the car?</h5>
                        <p>
                            The gas tank should be full at the start of your shift. If the gas tank is not at full, contact Car Flo Support and submit a picture of the gas gauge through the app. All vehicles must be returned with a full gas tank. There is a $40 fee for any vehicles returned without a full tank of gas.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Do I have to clean my car?</h5>
                        <p>
                            It is the responsibility of the renter to make sure that the vehicle is returned clean without any sort of odor. If your vehicle is messy at the start of your shift submit a photo through the app and contact Car Flo Support.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Can I smoke in my vehicle?</h5>
                        <p>
                            You may not smoke in any of the Car Flo vehicles. There will be a $250 cleaning fee for any rental returned with an odor.
                        </p>
                    </div>
                    <div class="step">
                        <h5>What happens if I leave something in the car?</h5>
                        <p>
                            Car Flo is not responsible for any items left in the car. Please double check the vehicle before you end your shift to make sure you did not leave anything behind.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Can I fix the car on my own?</h5>
                        <p>
                            No, all Car Flo cars must be maintained by a Car Flo authorized maintenance shop. Vehicle owners who make their vehicles available through Car Flo will handle all maintenance for their cars.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Can I use this car for personal use?</h5>
                        <p>
                            Once you rent a car you can use it for any purpose you want. We encourage drivers to use Uber, Lyft, Via, and Juno so you can maximize your earnings.
                        </p>
                    </div>
                    <div class="step">
                        <h5>Can my spouse or friend drive the vehicle?</h5>
                        <p>
                            Only the employees of Car Flo and Car Flo vehicle renters may drive Car Flo vehicles.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_custom_script')
    <script>

    </script>
@endsection