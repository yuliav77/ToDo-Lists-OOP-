document.addEventListener('DOMContentLoaded', function() {

    const submitNewTaskButtons = document.querySelectorAll('.submitNewTask');
    const newTaskInputs = document.querySelectorAll('.taskTitle');
    const submitNewList = document.querySelector('#submitNewList');
    const newList = document.querySelector('#listTitle');


	if (submitNewTaskButtons){
		submitNewTaskButtons.forEach((el) => {
			el.disabled = true;
		});
	}

	if (newTaskInputs){
		[].forEach.call(newTaskInputs, function(el) {
			el.onkeyup = function(e) {
				if (e.currentTarget.value.length > 0) {
					e.currentTarget.parentNode.querySelector('.submitNewTask').disabled = false;
				}
				else {
					e.currentTarget.parentNode.querySelector('.submitNewTask').disabled = true;
				}
			}			
		});
	}
	
    if (submitNewList) {
		submitNewList.disabled = true;
	}

	if (newList) {
		newList.onkeyup = () => {
			if (newList.value.length > 0) {
				submitNewList.disabled = false;
			}
			else {
				submitNewList.disabled = true;
			}
		}
	}
	
});