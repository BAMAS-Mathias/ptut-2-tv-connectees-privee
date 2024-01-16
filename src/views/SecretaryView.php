<?php

namespace Views;

use Controllers\UserController;
use Models\CodeAde;
use Models\Course;
use Models\DailySchedule;
use Models\Model;
use Models\Room;
use Models\User;
use Models\WeeklySchedule;

/**
 * Class SecretaryView
 *
 * All view for secretary (Forms, tables, messages)
 *
 * @package Views
 */
class SecretaryView extends UserView
{
    /**
     * Display the creation form
     *
     * @return string
     */
    public function displayFormSecretary()
    {
        return '
        <h2>Compte secrétaire</h2>
        <p class="lead">Pour créer des secrétaires, remplissez ce formulaire avec les valeurs demandées.</p>
        ' . $this->displayBaseForm('Secre');
    }

    /**
     * Displays the admin dashboard
     * @author Thomas Cardon
     */
    public function displayContent()
    {
        return '<section class="container col-xxl-10">
      <div class="row flex-lg-row-reverse align-items-center g-5 mb-5">
        <div class="col-10 col-sm-8 col-lg-6">
          <img draggable="false" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Aix-Marseille_université_%28logo%29.png/1920px-Aix-Marseille_université_%28logo%29.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" loading="lazy" width="700" height="500">
        </div>
        <div class="col-lg-6">
          <h1 class="display-5 fw-bold title-bold">' . get_bloginfo("name") . '</h1>
          <p class="lead">
            Créez des informations pour toutes les télévisions connectées, les informations seront affichées sur chaque télévisions en plus des informations déjà publiées.
            Les informations sur les télévisions peuvent contenir du texte, des images et même des pdf.
            <br /> <br />
            Vous pouvez faire de même avec les <b>alertes</b> des télévisions connectées.
            Les informations seront affichées dans la partie droite, et les alertes dans le bandeau rouge en bas des TV.
          </p>
        </div>
      </div>
      <div class="row align-items-md-stretch my-2">
        <div class="col-md-6">
          <div class="h-100 p-5 text-white bg-dark rounded-3">
            <h2 class="title-block">(+) Ajouter</h2>
            <p>Ajoutez une information ou une alerte.</p>
            <a href="' . home_url('/creer-information') . '" class="btn btn-outline-light" role="button">Information</a>
            <a href="' . home_url('/gerer-les-alertes') . '" class="btn btn-outline-light" role="button">Alerte</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="h-100 p-5 text-white bg-danger border rounded-3">
            <h2 class="title-block">Interface secrétaires</h2>
            <p>Accédez au mode tablette.</p>
            <a href="' . home_url('/secretary/homepage') . '" class="btn btn-dark" role="button">Voir</a>
          </div>
        </div>
      </div>
      <div class="row align-items-md-stretch my-2 mb-5">
        <div class="col-md-6">
          <div class="h-100 p-5 bg-light border rounded-3">
            <h2 class="title-block title-bold">👷 Personnel</h2>
            <p>Ajoutez des utilisateurs qui pourront à leur tour des informations, alertes, etc.</p>
            <a href="' . home_url('/creer-utilisateur') . '" class="btn btn-danger" role="button">Créer</a>
            <a href="' . home_url('/users/list') . '" class="btn btn-dark" role="button">Voir</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="h-100 p-5 text-white bg-info rounded-3">
            <h2 class="title-block">Emploi du temps</h2>
            <p>Forcez l\'actualisation des emplois du temps.</p>
            <form method="post" id="dlAllEDT">
              <input id="dlEDT" class="btn btn-outline-light" type="submit" name="dlEDT" value="🔄️ Actualiser" />
            </form>
          </div>
        </div>
      </div>
    </section>';
    }

    /**
     * Display all secretary
     *
     * @param $users    User[]
     *
     * @return string
     */
    public function displayTableSecretary($users)
    {
        $title = '<b>Rôle affiché: </b> Secrétaire';
        $name = 'Secre';
        $header = ['Identifiant'];

        $row = array();
        $count = 0;
        foreach ($users as $user) {
            ++$count;
            $row[] = [$count, $this->buildCheckbox($name, $user->getId()), $user->getLogin()];
        }

        return $this->displayTable($name, $title, $header, $row, 'Secre', '<a type="submit" class="btn btn-primary" role="button" aria-disabled="true" href="' . home_url('/creer-utilisateur') . '">Créer</a>');
    }

    /**
     * Ask to the user to choose an user
     */
    public function displayNoUser()
    {
        return '<p class="alert alert-danger">Veuillez choisir un utilisateur</p>';
    }

    /**
     * Displays the form to create a new user
     *
     * @return string
     */
    public function displayUserCreationForm() : string
    {
        return '<div class="container col-xxl-10">
        <h2 class="display-6">Créer un utilisateur</h2>
        <p class="lead">Pour créer un utilisateur, remplissez ce formulaire avec les valeurs demandées.</p>

        <hr class="my-4">
        
        ' . (isset($_GET['message']) ? '<div class="alert alert-' . $_GET['message'] . '">' . $_GET['message_content'] . '</div>' : '') . '

        <form method="post" action="' . admin_url('admin-post.php') . '">
          <div class="form-outline mb-2">
            <label class="form-label" for="form3Example1cg">Identifiant du compte</label>
            <input type="text" id="login" name="login" placeholder="Exemple: prenom.nom" class="form-control form-control-lg" minlength="3" required />
          </div>

          <div class="form-outline mb-2">
            <label class="form-label" for="email">Votre adresse e-mail</label>
            <input type="email" id="email" name="email" class="form-control form-control-lg" required />
          </div>

          <div class="form-outline mb-2">
            <label class="form-label" for="password">Mot de passe - <i>requis: 1 chiffre, 1 lettre majuscule, 1 lettre minuscule, et 1 symbole parmis ceux-ci: <kbd> !@#$%^&*_=+-</kbd></i></label>
            <input type="password" id="password" name="password1" class="form-control form-control-lg" minlength="8" required />
          </div>

          <div class="form-outline mb-2">
            <label class="form-label" for="password2">Confirmez votre mot de passe</label>
            <input type="password" id="password2" name="password2" class="form-control form-control-lg" minlength="8" required />
          </div>

          <input type="hidden" name="action" value="create_user">

          <div class="form-outline mb-2 pb-4">
            <label class="form-label" for="role">Rôle</label>
            <select class="form-control form-control-lg" id="role" name="role">
              <option value="secretary">Secrétaire</option>
              <option value="admin">Administrateur</option>
              <option value="teacher">Enseignant</option>
              <option value="television">Télévision</option>
              <option value="technician">Technicien</option>
              <option value"studyDirector">Directeur d\'études</option>
            </select>
          </div>
          
          <input type="submit" class="btn btn-primary" role="button" aria-disabled="true" value="Créer">
          <a href="' . home_url('/users/list') . '" class="btn btn-secondary" role="button" aria-disabled="true">Annuler</a>
        </form>
      </div>';
    }

    public function displayUserCreationFormExcel() : string {
        return '<div class="container col-xxl-10">
        <h2 class="display-6">Créer un utilisateur</h2>
        <p class="lead">
          Pour créer un utilisateur, <a href="#">téléchargez le fichier CSV</a> et remplissez les champs demandés.
        </p>

        <hr class="my-4">
        
        ' . (isset($_GET['message']) ? '<div class="alert alert-' . $_GET['message'] . '">' . $_GET['message_content'] . '</div>' : '') . '

        <form method="post" action="' . admin_url('admin-post.php') . '">
          <div class="form-outline mb-2">
            <label for="file" class="form-label">Déposez le fichier Excel ici</label>
            <input class="form-control form-control-lg" id="file" type="file" />
          </div>

          <input type="hidden" name="action" value="createUsers">
        </form>
      </div>';
    }

    public function displaySecretaryWelcome() : string{
        return'
        <div class="btn-container">
            <a href="' . home_url('/secretary/year-student-schedule?year=1') . '" class="boutons-etudiants secretary-button blue-btn">BUT1</a> 
            <a href="' . home_url('/secretary/year-student-schedule?year=2') . '" class="boutons-etudiants secretary-button blue-btn">BUT2</a> 
            <a href="' . home_url('/secretary/year-student-schedule?year=3') . '" class="boutons-etudiants secretary-button blue-btn">BUT3</a> 
            <a href="' . home_url('/secretary/teacher-search-schedule') . '" class="boutons-autres secretary-button orange-btn">ENSEIGNANTS</a> 
            <a href="' . home_url('/secretary/computer-rooms') . '"class="boutons-autres secretary-button orange-btn">SALLES MACHINES</a>
            <a href="' . home_url('/secretary/room-schedule') . '" class="boutons-autres secretary-button orange-btn">SALLES DISPONIBLES</a>
        </div>';
    }

    public function displayComputerRoomsAvailable($computerRoomList){
        $view =
            '<div id="main-container">';

        foreach($computerRoomList as $room){
            $view .= '';
            if(!$room->isAvailable()){
                $view .= '<form class="room not-available">';
            }
            else{
                $view .= '<form class="room available" method="post" action="' . home_url("/secretary/lock-room") . '">
                            <input type="hidden" name=roomName value="' . $room->getName() . '">
                            <input type="submit" style="position:absolute; opacity: 0; width: 100%; height: 100%">';
            }
            $view .= '
                            <img class="lock-open" src="'. TV_PLUG_PATH . 'public/img/lock-open.png' .'">
                            <img class="lock-close" src="'. TV_PLUG_PATH . 'public/img/lock-close.png' .'">
                            <img class="computer-icon" src="'. TV_PLUG_PATH . 'public/img/computer-icon.png' .'">
                            <h1 class="label-salle">' . $room->getName() . '</h1>
                       </form>';
        }

        return $view . '</div>';
    }

    public function displayStudentGroupView(){
        $schedule = new WeeklySchedule('42525');
        $view = '<div class="container-body">               
                    <p id="text-horaire">8h15 - 10h15</p>        
                    <p id="text-horaire">10h35 - 12h15</p>      
                    <p id="text-horaire">13h30 - 15h15</p> 
                    <p id="text-horaire">15h45 - 17h30</p>
                    ';

        foreach($schedule->getDailySchedules() as $dailySchedule){
            if($dailySchedule->getDate() != date('Ymd')) continue;
            $previousCourseDuration = null;
            foreach ($dailySchedule->getCourseList() as $course){
                $courseDuration = preg_split('/ - /', $course->getDuration());
                if($courseDuration == $previousCourseDuration) continue;
                $previousCourseDuration = $courseDuration;


                if($course->getGroup())
                $view .= '<div class="container-matiere orange">
                            <p class="text-matiere">' . $course->getSubject() . '</p>
                            <p class="text-prof">' . $course->getTeacher() . '</p>
                            <p class="text-salle">' . $course->getLocation() . '</p>
                          </div>';
            }
        }

        $view .= '</div>';
        return $view;
    }

    public function displayYearGroupRow($weeklySchedule){
        $view = '';
        foreach($weeklySchedule->getDailySchedules() as $dailySchedule){
            if($dailySchedule->getDate() != date('Ymd')) continue;
            $courseList = $dailySchedule->getCourseList();
            if($courseList == []){
                for($i = 0; $i<8; $i++){
                    $view .= '<div></div>';
                }
            }
            for ($i = 0; $i < sizeof($courseList); $i++) {
                $course = $courseList[$i];
                if ($course != null) {
                    if($course->isDemiGroupe() && $courseList[$i + 1]->isDemiGroupe()){
                        $view .= $this->displayHalfGroupCourse($course, $courseList[$i + 1]);
                        $i++;
                    }else{
                        $view .= $this->displayGroupCourse($course);
                    }
                }else{
                    $view .= '<div></div>';
                }
            }
        }

        return $view;
    }

    public function displayHalfGroupCourse($firstGroupCourse, $secondGroupCourse) : string{
        $view = '<div style="grid-column: span ' . $firstGroupCourse->getDuration() . ';display: grid; row-gap: 10px">';
        $view .= $this->displayGroupCourse($firstGroupCourse, true);
        $view .= $this->displayGroupCourse($secondGroupCourse, true);
        $view .= '</div>';
        return $view;
    }

    public function displayGroupCourse($course, $halfsize = false) : string{
        $view = '<div class="container-matiere"';
        if($halfsize){
            $view .= 'demi-groupe';
        }
        $view .= '" style="grid-column: span ' . $course->getDuration() . ';background-color:' . $course->getColor() . ';">
                        <p class="text-matiere">' . $course->getSubject() . '</p>
                        <p class="text-prof">' . $course->getTeacher() . '</p>
                        <p class="text-salle">' . $course->getLocation() . '</p>
                    </div>';
        return $view;
    }

    /* TEMPORAIRE */
    public function displayYearStudentScheduleView($groupCodeNumbers){
        $view = '<div id="schedule-container">
                    <div></div>                  
                        <p id="text-horaire">8h15 - 10h15</p>                  
                        <p id="text-horaire">10h35 - 12h15</p>                                   
                        <p id="text-horaire">13h30 - 15h15</h3>
                        <p id="text-horaire">15h45 - 17h30</p>                    
                    ';

        $groupIndex = 1;

        foreach ($groupCodeNumbers as $groupCodeNumber){
            $view .= '<p class="group-name">G' . $groupIndex . '</p>';
            $groupIndex++;

            $weeklySchedule = new WeeklySchedule($groupCodeNumber);
            $view .= $this->displayYearGroupRow($weeklySchedule);
        }

        return $view;
    }

    /**
     * @param DailySchedule[] $dailySchedulesList
     * @return string
     */
    public function displayComputerRoomSchedule($dailySchedulesList){
        $dayNameList = ['LUNDI','MARDI','MERCREDI','JEUDI','VENDREDI'];
        $view = '<div id="schedule-container">
                     <div></div>
                     <p class="hour-text">8h15 - 10h15</p>
                     <p class="hour-text">10h35 - 12h15</p>
                     <p class="hour-text">13h30 - 15h15</p>
                     <p class="hour-text">15h45 - 17h30</p>';

        for($i = 0; $i < sizeof($dailySchedulesList); ++$i){
            $dailySchedule = $dailySchedulesList[$i];
            $view .= '<p class="text-horaire">' . $dayNameList[$i] . '</p>';

            if(empty($dailySchedule->getCourseList())){
                $view .= '<div style="grid-row: span 8"></div>';
            }
            foreach ($dailySchedule->getCourseList() as $course){
                if($course == null){
                    $view .= '<div></div>';
                    continue;
                }

                $view .= '<div class="container-matiere" style="grid-row: span ' . $course->getDuration().'; background-color: ' . $course->getColor() .'">
                             <p class="text-matiere">' . $course->getSubject() .'</p>
                             <p class="text-prof">' . $course->getTeacher() .'</p>
                             <p class="text-group">' . $course->getGroup() . '</p>
                          </div>';
            }
        }

        return $view . '<div>';
    }
    public function displayHomePage()
    {
        return '
    <body>
        <div class="container">
            <h1 id="bienvenue">
                BIENVENUE AU BUT <br>
                INFORMATIQUE <br>
                D\'AIX-MARSEILLE
            </h1>
        </div>
    </body>
    <footer>
        <h2>
            . <!-- Ne pas enlever -->
        </h2>
    </footer>
    </html>';
    }

    /**
     * @param Course[] $courseList
     * @return void
     */
    public function displayScheduleConfig($courseList) : string{
        $view = '<form class="course-config-container" method="post" action="' . home_url('/blocks/course-color/modify') . '">';
        $index = 0;

        foreach ($courseList as $course) {
            $view .= '<div class="course-config" style="background-color: ' . $course->getColor(). '">
                   <p>' . $course->getSubject() . '</p>
                   <input type="hidden" name="hidden[' . $index . ']" value="' . $course->getSubject() . '">
                   <input name="color[' . $index . ']" class="course-config-color-selector" type="color" value="' . $course->getColor() . '">
              </div>';
            $index++;
        }

        $view .= '<input type="submit" value="MODIFIER"></form>';
        return $view;
    }

    public function displayRoomChoice($roomList) : string{
        $view = '<form method="post" action="' . home_url("/secretary/weekly-computer-room-schedule"). '">
                    <select name="roomName">';

        foreach($roomList as $room){
            $view .= '<option>'. $room->getName() . '</option>';
        }
        $view .='<input type="submit"></form>';

        return $view;
    }

    public function displaySecretaryConfig(){
        $view = '<div class=container>
                    <a href="' . home_url('/secretary/config-schedule') . '">                   
                        <img src="'. TV_PLUG_PATH . 'public/img/palette-icon.png' .'">    
                        <p>COULEUR</p>                
                    </a>
                    <a href="' . home_url('/secretary/config-schedule') . '">
                        <img src="'. TV_PLUG_PATH . 'public/img/group-icon.png' .'">
                        <p>GROUPES</p>
                    </a>
                 </div>';

        return $view;
    }

    public function displayRoomSchedule($dailySchedule){
            $view =
                '<div class="container-body">       
                <p id="text-horaire">8h15 - 10h15</p>   
                <p id="text-horaire">10h35 - 12h15</p>                    
                <p id="text-horaire">13h30 - 15h15</p>          
                <p id="text-horaire">15h45 - 17h30</p>
            ';

            $courseList = $dailySchedule->getCourseList();
            if($courseList == []){
                $view .= '<h3 style="grid-column: span 8; justify-self: center; font-size: 32px"> Pas de cours aujourd\'hui</h2>';
            }
            foreach ($courseList as $course) {
                if ($course != null) {
                    $view .= '<div class="container-matiere green" style="grid-column: span ' . $course->getDuration() . '">
                            <p class="text-matiere">' . $course->getSubject() . '</p>
                            <p class="text-prof">' . $course->getTeacher() . '</p>
                            <p class="text-salle">' . $course->getLocation() . '</p>
                        </div>';
                }else{
                    $view .= '<div></div>';
                }

            }

            $view .= '</div>';

            return $view;
    }

    /**
     * @param Room[] $roomList
     * @return void
     */
    public function displayRoomSelection($roomList) : string{
        $view = '<form id="room-choice-form" method="post" action="' . home_url("/secretary/room-schedule") . '">
                    <select name="roomName" >';
        if(isset($_POST['roomName'])){
            $view .= '<option value="" disabled selected hidden>' . $_POST['roomName'] . '</option>';
        }
        foreach ($roomList as $room){
            $view .= '<option>' . $room->getName() . '</option>';
        }
          $view .= '</select>
                        <input type=image  src="https://cdn-icons-png.flaticon.com/512/694/694985.png">
                </form>';
        return $view;
    }

    /**
     * @param string $room
     * @return void
     */
    public function displayRoomLock($roomName){
        $view = '<div class="lock-room-form-container">
                    <h3>Verrouiller la salle ' . $roomName .  '</h3>
                    <form>
                        <label>Motif</label><textarea name="motif"></textarea>
                        <label>Date de fin</label><input type="date" required> 
                        <label>Heure</label><input type="time" required>
                        <input type="submit" value="Verrouiller">
                    </form>
                 </div>';

        return $view;
    }

}
