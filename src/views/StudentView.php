<?php

namespace Views;


use Models\CodeAde;
use Models\User;

/**
 * Class StudentView
 *
 * All view for student (Forms, tables, messages)
 *
 * @package Views
 */
class StudentView extends UserView
{

    /**
     * Form to create users with an Excel file
     *
     * @return string   Renvoie le formulaire
     */
    public function displayInsertImportFileStudent()
    {
	    return '
        <div class="cadre">
        	<h2>Compte étudiant</h2>
            <a href="' . TV_PLUG_PATH . 'public/files/Ajout Etus.xlsx"
                download="Ajout Etus.xlsx">Télécharger le fichier excel ! </a>
            <form id="etu" method="post" enctype="multipart/form-data">
				<input type="file" name="excelEtu" class="inpFil" required=""/>
				<button type="submit" name="importEtu" value="Importer">Importer le fichier</button>
			</form>
		</div>';
    }

	/**
	 * Display all students in a table
	 *
	 * @param $users    User[]
	 *
	 * @return string
	 */
    public function displayAllStudent($users)
    {
	    $page = get_page_by_title('Modification utilisateur');
	    $linkManageUser = get_permalink($page->ID);

	    $title = 'Étudiants';
	    $name = 'etu';
	    $header = ['Numéro étudiant', 'Année', 'Groupe', 'Demi groupe', 'Modifier'];

	    $row = array();
	    $count = 0;

	    foreach ($users as $user) {

		    $codes = $user->getCodes();
		    $codesTitle = array();
		    foreach ($codes as $code) {
		    	if($code instanceof CodeAde) {
		    		$codesTitle[] = $code->getTitle();
			    } else {
		    		$codesTitle[] = $code;
			    }
		    }

	    	++$count;
	    	$row[] = [$count, $this->buildCheckbox($name, $user->getId()), $user->getLogin(), $codesTitle[0], $codesTitle[1], $codesTitle[2], $this->buildLinkForModify($linkManageUser.'/'.$user->getId())];
	    }

	    return $this->displayAll($name, $title, $header, $row, 'student');
    }

	/**
	 * Display the form to modify the student
	 *
	 * @param $user         User
	 * @param $years        CodeAde[]
	 * @param $groups       CodeAde[]
	 * @param $halfGroups   CodeAde[]
	 *
	 * @return string
	 */
    public function displayModifyStudent($user, $years, $groups, $halfGroups)
    {
        $page = get_page_by_title('Gestion des utilisateurs');
        $linkManageUser = get_permalink($page->ID);

        $form = '
         <form method="post">
            <h2>' . $user->getLogin() . '</h2>
            <div class="form-group">
            	<label for="modifYear">Année</label>
            	<select id="modifYear" class="form-control" name="modifYear">';

        if($user->getCodes()[0] instanceof CodeAde) {
        	$form .= '<option value="' . $user->getCodes()[0]->getCode() . '">' . $user->getCodes()[0]->getTitle() . '</option>';
        }
        $form .= '
        <option value="0">Aucun</option>
        <optgroup label="Année">';

        foreach ($years as $year) {
	        $form .= '<option value="' . $year->getCode() . '">' . $year->getTitle() . '</option >';
        }
	    $form .= '
            	</optgroup>
        	</select>
        </div>
        <div class="form-group">
        	<label for="modifGroup">Groupe</label>
        	<select id="modifGroup" class="form-control" name="modifGroup">';

        if($user->getCodes()[1] instanceof CodeAde) {
        	$form .= '<option value="' . $user->getCodes()[1]->getCode() . '">' . $user->getCodes()[1]->getTitle() . '</option>';
        }
        $form .='<option value="0">Aucun</option>
                 <optgroup label="Groupe">';

        foreach ($groups as $group) {
	        $form .= '<option value="' . $group->getCode() . '">' . $group->getTitle() . '</option>';
        }
	    $form .= '
            	</optgroup>
        	</select>
        </div>
        <div class="form-group">
        	<label for="modifHalfgroup">Demi-groupe</label>
        	<select id="modifHalfgroup" class="form-control" name="modifHalfgroup">';

        if($user->getCodes()[2] instanceof CodeAde) {
        	$form .= '<option value="' . $user->getCodes()[2]->getCode() . '">' . $user->getCodes()[2]->getTitle() . '</option>';
        }
        $form .= '<option value="0"> Aucun</option>
                  <optgroup label="Demi-Groupe">';

        foreach ($halfGroups as $halfGroup) {
	        $form .= '<option value="' . $halfGroup->getCode() . '">' . $halfGroup->getTitle() . '</option>';
        }
	    $form .= '
	        		</optgroup>
	        	</select>
	        </div>
	        <input name="modifvalider" type="submit" value="Valider">
	    	<a href="' . $linkManageUser . '">Annuler</a>
	    </form>';

        return $form;
    }

	/**
	 * Display a list of groups for the inscription of the student
	 *
	 * @param $years            CodeAde[]
	 * @param $groups           CodeAde[]
	 * @param $halfGroups       CodeAde[]
	 */
	public function selectSchedules($years, $groups, $halfGroups)
	{
		echo '
	    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
	      <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title"> Choix des emplois du temps</h5>
	          </div>
	          <div class="modal-body">
		          <p>Bienvenue sur l\'écran connecté, sélectionnez vos emplois du temps afin de pouvoir utiliser ce site</p>
		          <form method="post">
		            <label for="selectYears">Sélectionne ton année</label>
		            <select class="form-control firstSelect" id="selectYears" name="selectYears">
		                <option value="0">Aucun</option>
		                <optgroup label="Année">';

		foreach ($years as $year) {
			echo '<option value="' . $year->getCode() . '">' . $year->getTitle() . '</option >';
		}
		echo '
			</optgroup>
	    </select>
	    <label for="selectGroups">Sélectionne ton groupe</label>
	    <select class="form-control firstSelect" id="selectGroups" name="selectGroups">
	        <option value="0">Aucun</option>
	        <optgroup label="Groupe">';

		foreach ($groups as $group) {
			echo '<option value="' . $group->getCode() . '">' . $group->getTitle() . '</option>';
		}
		echo '
			</optgroup>
	    </select>
	    <label for="selectHalfgroups">Sélectionne ton demi-groupe</label>
	    <select class="form-control firstSelect" id="selectHalfgroups" name="selectHalfgroups">
	        <option value="0">Aucun</option>
	        <optgroup label="Demi groupe">';

		foreach ($halfGroups as $halfgroup) {
			echo '<option value="' . $halfgroup->getCode() . '">' . $halfgroup->getTitle() . '</option>';
		}
		echo '
							</optgroup>
	                    </select>
	                    <input type="submit" name="addSchedules">
	                </form>
	            </div>
	        </div>
	      </div>
	    </div>
	    
	    <script> $("#myModal").show() </script>';
	}
}