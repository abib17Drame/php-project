document.addEventListener("DOMContentLoaded", function() {
    const profilSelect = document.getElementById('profil');
    const athleteChoice = document.getElementById('athleteChoice');
    const btnEquipe = document.getElementById('btnEquipe');
    const btnIndividuel = document.getElementById('btnIndividuel');
    const btnRetourAthlete = document.getElementById('btnRetourAthlete');
  
    const commonFields = document.getElementById('commonFields');
    const arbitreFields = document.getElementById('arbitreFields');
    const equipeFields = document.getElementById('equipeFields');
    const individuelFields = document.getElementById('individuelFields');
    const submitButton = document.getElementById('submitButton');
  
    // Masquer un élément
    function hide(el) {
      el.classList.add('hidden');
    }
    // Afficher un élément
    function show(el) {
      el.classList.remove('hidden');
    }
  
    // Lors du changement du select "profil"
    profilSelect.addEventListener('change', function() {
      const profil = this.value;
      // On réinitialise
      hide(commonFields);
      hide(arbitreFields);
      hide(athleteChoice);
      hide(equipeFields);
      hide(individuelFields);
      hide(submitButton);
  
      if (profil === 'arbitre') {
        show(commonFields);
        show(arbitreFields);
        show(submitButton);
      } else if (profil === 'athlete') {
        show(athleteChoice);
      }
    });
  
    // Choix équipe
    btnEquipe.addEventListener('click', function() {
      show(commonFields);
      show(equipeFields);
      hide(individuelFields);
      hide(athleteChoice);
      show(btnRetourAthlete);
      show(submitButton);
    });
  
    // Choix individuel
    btnIndividuel.addEventListener('click', function() {
      show(commonFields);
      show(individuelFields);
      hide(equipeFields);
      hide(athleteChoice);
      show(btnRetourAthlete);
      show(submitButton);
    });
  
    // Bouton retour
    btnRetourAthlete.addEventListener('click', function() {
      hide(commonFields);
      hide(equipeFields);
      hide(individuelFields);
      hide(btnRetourAthlete);
      hide(submitButton);
      show(athleteChoice);
    });
  });
  