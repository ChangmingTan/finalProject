<?php

class Controller
{
    private $_f3; //router
    private $_validator; //validation object

    /**
     * Controller constructor.
     * @param $f3
     * @param $validator
     */
    public function __construct($f3, $validator)
    {
        $this->_f3 = $f3;
        $this->_validator = $validator;
    }

    /**
     * Display the default route
     */
    public function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Display the information route
     */
    public function information()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);

            // Validate first name
            if (!$this->_validator->validName($_POST['fName'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["fName"]', "Invalid first name");
            }
            // Validate last name
            if (!$this->_validator->validName($_POST['lName'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["lName"]', "Invalid last name");
            }
            // Validate phone number
            if (!$this->_validator->validPhone($_POST['phone'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["phone"]', "A valid phone number contains numbers between 0 and 9, 10 digits, with no punctuation");
            }
            // Validate email address
            if (!$this->_validator->validEmail($_POST['email'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["email"]', "Invalid email");
            }
            // Data is valid
            if (empty($this->_f3->get('errors'))) {
                //Store the data in the session array
                $_SESSION['fName'] = $_POST['fName'];
                $_SESSION['lName'] = $_POST['lName'];
                $_SESSION['phone'] = $_POST['phone'];
                $_SESSION['email'] = $_POST['email'];

                // Reroute to the next page
                $this->_f3->reroute('car');
            }

        }

        $this->_f3->set('fName', $_POST['fName']);
        $this->_f3->set('lName', $_POST['lName']);
        $this->_f3->set('phone', $_POST['phone']);
        $this->_f3->set('email', $_POST['email']);


        $view = new Template();
        echo $view->render('views/information.html');
    }

    /**
     * Display the car route
     */
    public function car()
    {
        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);

            // Validate the model
            if (!$this->_validator->validModel($_POST['makeDrop'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["makeDrop"]', "Please pick an item from the dropdown menu");
            }
            // Validate the year
            if (!$this->_validator->validYear($_POST['yearDrop'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["yearDrop"]', "Please pick an item from the dropdown menu");
            }
            // Validate the drive-train option
            if (!$this->_validator->validDriveTrain($_POST['driveTrain'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["driveTrain"]', "Please pick a drive-train option");
            }
            // Data is valid
            if (empty($this->_f3->get('errors'))) {
                //Store the data in the session array
                $_SESSION['model'] = $_POST['makeDrop'];
                $_SESSION['year'] = $_POST['yearDrop'];
                $_SESSION['driveTrain'] = $_POST['driveTrain'];

                //Redirect to exterior page
                $this->_f3->reroute('exterior');
            }
        }

        $this->_f3->set('models', getModel());
        $this->_f3->set('selectedModel', $_POST['makeDrop']);
        $this->_f3->set('years', getYear());
        $this->_f3->set('selectedYear', $_POST['yearDrop']);
        $this->_f3->set('driveTrains', getWheel());
        $this->_f3->set('selectedDriveTrain', $_POST['driveTrain']);

        $view = new Template();
        echo $view->render('views/car.html');
    }

    /**
     * Display the exterior route
     */
    public function exterior()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);

            // Validate the size of the rims
            if (!$this->_validator->validRim($_POST['rimDrop'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["rimDrop"]', "Please select a rim size");
            }
            // Validate if the customer wants spinners added on vehicle
            if (!$this->_validator->validSpinner($_POST['spinners'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["spinners"]', "Please select a rim size");
            }
            // Validate the color of the vehicle
            if (!$this->_validator->validColor($_POST['colorCar'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["colorCar"]', "Please select color of vehicle");
            }
            // Validate the type of exhaust
            if (!$this->_validator->validExhaust($_POST['exhaust'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["exhaust"]', "Please select the type of exhaust");
            }
            // Validate the type of engine
            if (!$this->_validator->validEngine($_POST['engine'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["engine"]', "Please select the type of engine");
            }
            // Validate the type of transmission
            if (!$this->_validator->validTransmission($_POST['transmission'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["transmission"]', "Please select the type of transmission");
            }
            // Data is valid
            if (empty($this->_f3->get('errors'))) {
                //Store the data in the session array
                $_SESSION['rim'] = $_POST['rimDrop'];
                $_SESSION['spinner'] = $_POST['spinners'];
                $_SESSION['color'] = $_POST['colorCar'];
                $_SESSION['exhaust'] = $_POST['exhaust'];
                $_SESSION['engine'] = $_POST['engine'];
                $_SESSION['transmission'] = $_POST['transmission'];
                $_SESSION['costumeExterior'] = $_POST['costumeExterior'];

                $this->_f3->reroute('interior');
            }
        }

        $this->_f3->set('rims', getRim());
        $this->_f3->set('selectedRim', $_POST['rimDrop']);
        $this->_f3->set('spinners', getSpinner());
        $this->_f3->set('selectedSpinner', $_POST['spinners']);
        $this->_f3->set('colors', getColor());
        $this->_f3->set('selectedColor', $_POST['colorCar']);
        $this->_f3->set('exhausts', getExhaust());
        $this->_f3->set('selectedExhaust', $_POST['exhaust']);
        $this->_f3->set('engines', getEngine());
        $this->_f3->set('selectedEngine', $_POST['engine']);
        $this->_f3->set('transmissions', getTransmission());
        $this->_f3->set('selectedTransmission', $_POST['transmission']);
        $this->_f3->set('costumeExterior', $_POST['costumeExterior']);

        $view = new Template();
        echo $view->render('views/exterior.html');
    }

    /**
     * Display the interior route
     */
    public function interior()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //array(5) { ["leather"]=> string(5) "Vinyl"
            // ["seats"]=> string(15) "2 seats 2 doors"
            // ["stereo"]=> string(14) "Bang & Olufsen"
            // ["nav"]=> string(26) "Yes, add navigation system"
            // ["head"]=> string(37) "No, don't add heads up display system" }
            //var_dump($_POST);
            // Validate the type of leather desired
            if (!$this->_validator->validLeather($_POST['leather'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["leather"]', "Please select a leather type");
            }
            // Validate the number of seats
            if (!$this->_validator->validSeats($_POST['seats'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["seats"]', "Please select number of seats");
            }
            // Validate the type of stereo system
            if (!$this->_validator->validStereo($_POST['stereo'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["stereo"]', "Please select type of stereo system");
            }
            // Validate the type of navigation system
            if (!$this->_validator->validNav($_POST['nav'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["nav"]', "Plase select if you would like a navigation system");
            }
            // Validate the type of heads up display
            if (!$this->_validator->validHead($_POST['head'])) {
                //Set an error variable in the F3 hive
                $this->_f3->set('errors["head"]', "Please select if you would like a heads up system");
            }

            // Data is valid
            if (empty($this->_f3->get('errors'))) {
                //Store the data in the session array
                $_SESSION['leather'] = $_POST['leather'];
                $_SESSION['seat'] = $_POST['seats'];
                $_SESSION['stereo'] = $_POST['stereo'];
                $_SESSION['navigation'] = $_POST['nav'];
                $_SESSION['headsUp'] = $_POST['head'];

                $this->_f3->reroute('summary');
            }
        }

        $this->_f3->set('leathers', getLeather());
        $this->_f3->set('selectedLeather', $_POST['leather']);
        $this->_f3->set('seats', getSeat());
        $this->_f3->set('selectedSeat', $_POST['seats']);
        $this->_f3->set('stereos', getStereo());
        $this->_f3->set('selectedStereo', $_POST['stereo']);
        $this->_f3->set('navigations', getNavigation());
        $this->_f3->set('selectedNavigation', $_POST['nav']);
        $this->_f3->set('headsUps', getHeadsUp());
        $this->_f3->set('selectedHeadsUp', $_POST['head']);

        $view = new Template();
        echo $view->render('views/interior.html');
    }

    /**
     * Display the summary route
     */
    public function summary()
    {
        $view = new Template();
        echo $view->render('views/summary.html');

        session_destroy();
    }
}
