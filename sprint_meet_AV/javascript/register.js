document.addEventListener("DOMContentLoaded", function () {
  const profilSelect = document.getElementById("profil");
  const athleteChoice = document.getElementById("athleteChoice");
  const commonFields = document.getElementById("commonFields");
  const equipeFields = document.getElementById("equipeFields");
  const individuelFields = document.getElementById("individuelFields");
  const arbitreFields = document.getElementById("arbitreFields");
  const submitButton = document.getElementById("submitButton");
  const btnEquipe = document.getElementById("btnEquipe");
  const btnIndividuel = document.getElementById("btnIndividuel");
  const btnRetour = document.getElementById("btnRetour");
  const champPrenom = document.getElementById("prenom").parentElement;
  const champNom = document.getElementById("nom").parentElement;

  let previousStep = null;

  // Fonction pour mettre à jour l'historique et afficher les étapes
  function updateHistory(step) {
      history.pushState({ step }, "", "");
  }

  // Fonction pour afficher l'étape en fonction de l'historique
  function showStep(step) {
      athleteChoice.classList.add("hidden");
      commonFields.classList.add("hidden");
      equipeFields.classList.add("hidden");
      individuelFields.classList.add("hidden");
      arbitreFields.classList.add("hidden");
      submitButton.classList.add("hidden");
      btnRetour.classList.add("hidden");
      champPrenom.classList.remove("hidden");
      champNom.classList.remove("hidden");

      if (step === "profil") {
          profilSelect.value = "";
          athleteChoice.classList.add("hidden");
          arbitreFields.classList.add("hidden");
          submitButton.classList.add("hidden");
          btnRetour.classList.add("hidden");
      } else if (step === "athleteChoice") {
          athleteChoice.classList.remove("hidden");
      } else if (step === "equipe") {
          commonFields.classList.remove("hidden");
          equipeFields.classList.remove("hidden");
          submitButton.classList.remove("hidden");
          btnRetour.classList.remove("hidden");
          champPrenom.classList.add("hidden");
          champNom.classList.add("hidden");
      } else if (step === "individuel") {
          commonFields.classList.remove("hidden");
          individuelFields.classList.remove("hidden");
          submitButton.classList.remove("hidden");
          btnRetour.classList.remove("hidden");
          champPrenom.classList.remove("hidden");
          champNom.classList.remove("hidden");
      } else if (step === "arbitre") {
          arbitreFields.classList.remove("hidden");
          submitButton.classList.remove("hidden");
      }
  }

  // Quand on change le profil
  profilSelect.addEventListener("change", function () {
      athleteChoice.classList.add("hidden");
      commonFields.classList.add("hidden");
      equipeFields.classList.add("hidden");
      individuelFields.classList.add("hidden");
      arbitreFields.classList.add("hidden");
      submitButton.classList.add("hidden");
      btnRetour.classList.add("hidden");

      if (profilSelect.value === "athlete") {
          athleteChoice.classList.remove("hidden");
          updateHistory("athleteChoice");
      } else if (profilSelect.value === "arbitre") {
          arbitreFields.classList.remove("hidden");
          submitButton.classList.remove("hidden");
          updateHistory("arbitre");
      }
  });

  // Quand on clique sur "Equipe"
  btnEquipe.addEventListener("click", function () {
      updateHistory("equipe");
      athleteChoice.classList.add("hidden");
      commonFields.classList.remove("hidden");
      equipeFields.classList.remove("hidden");
      individuelFields.classList.add("hidden");
      submitButton.classList.remove("hidden");
      btnRetour.classList.remove("hidden");
      champPrenom.classList.add("hidden");
      champNom.classList.add("hidden");
  });

  // Quand on clique sur "Individuel"
  btnIndividuel.addEventListener("click", function () {
      updateHistory("individuel");
      athleteChoice.classList.add("hidden");
      commonFields.classList.remove("hidden");
      individuelFields.classList.remove("hidden");
      equipeFields.classList.add("hidden");
      submitButton.classList.remove("hidden");
      btnRetour.classList.remove("hidden");
      champPrenom.classList.remove("hidden");
      champNom.classList.remove("hidden");
  });

  // Quand on clique sur "Retour"
  btnRetour.addEventListener("click", function () {
      history.back();
  });

  // Quand l'utilisateur appuie sur la flèche de retour du navigateur
  window.addEventListener("popstate", function (event) {
      if (event.state && event.state.step) {
          showStep(event.state.step);
      }
  });

  // Gestion des disciplines selon le sexe
  const disciplinesIndividuel = {
      homme: ['100m', '200m', '400m', '800m', '1500m', '110m haies', '400m haies'],
      femme: ['100m', '200m', '400m', '800m', '1500m', '100m haies', '400m haies']
  };

  const disciplinesEquipe = {
      homme: ['4x400m relais'],
      femme: ['4x400m relais']
  };

  // Mise à jour des disciplines individuelles en fonction du sexe
  document.getElementById('sexe').addEventListener('change', function () {
      const sexe = this.value;
      const disciplineSelect = document.getElementById('discipline');
      const options = disciplinesIndividuel[sexe] || [];
      disciplineSelect.innerHTML = '<option value="">Choisissez la discipline</option>';
      options.forEach(function (discipline) {
          const option = document.createElement('option');
          option.value = discipline;
          option.textContent = discipline;
          disciplineSelect.appendChild(option);
      });
  });

  // Mise à jour des disciplines par équipe en fonction du sexe
  document.getElementById('sexe_equipe').addEventListener('change', function () {
      const sexe = this.value;
      const disciplineSelect = document.getElementById('discipline_equipe');
      const options = disciplinesEquipe[sexe] || [];
      disciplineSelect.innerHTML = '<option value="">Choisissez la discipline</option>';
      options.forEach(function (discipline) {
          const option = document.createElement('option');
          option.value = discipline;
          option.textContent = discipline;
          disciplineSelect.appendChild(option);
      });
  });
});