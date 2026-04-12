// Helperfunctie om een toastmelding na 3 seconden te verwijderen
export function clearToastMessage(toastMessage) {
    // setTimeout voert de functie uit na een opgegeven tijd in milliseconden
    // 3000 milliseconden = 3 seconden
    setTimeout(() => {
        toastMessage.value = ''
    }, 3000)
}