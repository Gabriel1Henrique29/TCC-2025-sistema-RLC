function changeStatus(button) {
    const currentStatus = button.textContent;

    // Alternar entre: C > F > A > C
    if (currentStatus === "C") {
        button.textContent = "F";
        button.style.backgroundColor = "#ff4d4d";  // Cor para falta
        button.style.color = "#fff";
        button.style.borderColor= "#ff4d4d"
    } else if (currentStatus === "F") {
        button.textContent = "A";
        button.style.backgroundColor = "#ffcc00";  // Cor para atraso
        button.style.color = "#fff";
        button.style.borderColor= "#ffcc00"
    } else if (currentStatus === "A") {
        button.textContent = "C";
        button.style.backgroundColor = "#00bf63";  // Cor para presente
        button.style.color = "#fff";
        button.style.borderColor= "#00bf63"

    }
}
