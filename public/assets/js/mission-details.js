window.onload = () => {
  document.getElementById('mission_nationality').addEventListener('input', function(){
    let xhr = new XMLHttpRequest()
    xhr.open("get", `/admin/mission/details/${this.value}`)
    xhr.addEventListener('readystatechange', function() {
      if(xhr.readyState === 4) {
          if(xhr.status !== 200) {
            alert('Une erreur s\'est produite, veuillez réessayer plus tard !')
          } else {
            const json = JSON.parse(xhr.response);
            console.log(json);
            const contacts = document.getElementById('mission_contact')
            // Efface les anciens éléments
            while(contacts.firstChild) {
              contacts.removeChild(contacts.firstChild);
            }
            contacts.innerHTML = `<option value="">--Liste contacts--</option>`
            // crée la liste avec les contacts du nouveau pays
            if(json['contacts']) {
              json['contacts'].forEach(elt => {
                contacts.insertAdjacentHTML('beforeend',`<option value="${elt.id}">${elt.firstname} ${elt.lastname} ${elt.nationality}</option>`)
              });
            }
            const hideouts = document.getElementById('mission_hideout')
            // Efface les anciens éléments
            while(hideouts.firstChild) {
              hideouts.removeChild(hideouts.firstChild);
            }
            hideouts.innerHTML = `<option value="">--Liste planques--</option>`
            // crée la liste avec les planques du nouveau pays
            if(json['hideouts']){
              json['hideouts'].forEach(elt => {
                  hideouts.insertAdjacentHTML('beforeend',`<option value="${elt.id}">${elt.code} ${elt.nationality}</option>`)
              });
            }
            alert('La sélection a été mise à jour avec succès.')
          }
        }
      })
    xhr.send()
  })
}