function startRecording() {
    // Vérifier si le navigateur prend en charge l'API MediaRecorder et l'API getUserMedia
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia && window.MediaRecorder) {
        // Demander l'autorisation d'accès au microphone
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function (stream) {
                // Créer une instance de MediaRecorder avec le flux audio obtenu
                let mediaRecorder = new MediaRecorder(stream);

                // Tableau pour stocker les morceaux de données audio enregistrées
                let chunks = [];

                // Gérer l'événement dataavailable pour collecter les données audio enregistrées
                mediaRecorder.addEventListener('dataavailable', function (event) {
                    chunks.push(event.data);
                });

                // Gérer l'événement stop pour finaliser l'enregistrement et obtenir les données audio complètes
                mediaRecorder.addEventListener('stop', function () {
                    // Créer un objet Blob contenant les données audio enregistrées
                    let audioBlob = new Blob(chunks, { type: 'audio/wav' });


                    chunks = [];

                    // Créer une instance de FormData pour envoyer les données
                    let formData = new FormData();
                    formData.append('audioBlob', audioBlob);

                    // Envoyer les données audio au serveur via une requête AJAX
                    fetch('/media/', {
                        method: 'POST',
                        body: formData
                    })
                        .then(function (response) {
                            if (response.ok) {
                                // Traitement des données de réponse si nécessaire
                                console.log('Enregistrement audio envoyé avec succès.');
                            } else {
                                console.error('Erreur lors de l\'envoi de l\'enregistrement audio.');
                            }
                        })
                        .catch(function (error) {
                            console.error('Erreur lors de l\'envoi de l\'enregistrement audio : ', error);
                        });
                });

                // Démarrer l'enregistrement lorsque le bouton est cliqué
                mediaRecorder.start();

                // Arrêter l'enregistrement après un certain temps (facultatif)
                // setTimeout(function() {
                //     mediaRecorder.stop();
                // }, 5000); // Arrêtez l'enregistrement après 5 secondes (à titre d'exemple)
            })
            .catch(function (error) {
                console.error('Erreur lors de l\'accès au microphone : ', error);
            });
    } else {
        console.error('Votre navigateur ne prend pas en charge l\'enregistrement audio.');
    }
}
