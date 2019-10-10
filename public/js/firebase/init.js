var myVar;
var cnt = 0;
var pageSize= 10;

function myStopFunction() {
	clearInterval(myVar);
}

function myTimer() {
	$('#pulsate-once').click();
}

// Initialize Firebase
var config = {
	apiKey: "AIzaSyBHnx_geZ8rQmH2YAZXRpT71j4aEojtoJo",
	authDomain: "sample-project-d89a3.firebaseapp.com",
	databaseURL: "https://sample-project-d89a3.firebaseio.com",
	projectId: "sample-project-d89a3",
	storageBucket: "",
	messagingSenderId: "491345133793",
	appId: "1:491345133793:web:8455cd2dca8e8a688777a0",
	measurementId: "G-HKHTZX0NT0"
};
firebase.initializeApp(config);

var database = firebase.database();

var lastIndex = 0;
var id = 1;
var loop_noti = 0;
// Get Data
function notification(value, paramValues = {}) {
	return '<li></li>';
}

dbRef = firebase.database().ref('notifications/');

dbRef.orderByChild("FromID").limitToLast(1).on('value', function (snapshot) {
	var value = snapshot.val();
	console.log(value);
	if(loop_noti == 0){
		loop_noti = 1;

	}else{
		$.each(value, function(index, value){
			if(value.to_type == 1 && value.to_id == 1){
				noti_count = (parseInt($('#notification_counter').text())+1);
				$('#notification_counter').text(noti_count);

				myVar = setInterval(myTimer, 1200);

				$('#notification_counter2').text(noti_count);
				$('#snackbar').html('New notification has been created please check.........');
				snicker();
				$('#msg').prepend('<li>' +
					'<a href="<?php echo url('/'); ?>/notification/'+value.notification_id+'"><span class="details"><span class="label label-sm label-icon label-danger md-skip"><i class="fa fa-bolt"></i></span> '+value.message+'. </span><span class="time">Just Now</span></a>' +
					'</li>');
			}
		});
	}

});

dbRef.on('child_changed', function (snapshot) {
	$('#'+snapshot.key).html('' +
		'<td id="from'+snapshot.key+'">'+snapshot.val().FromID+'</td>' +
		'<td id="to'+snapshot.key+'">'+snapshot.val().ToID+'</td>' +
		'<td><button class="btn-remove-key"  data-key="' + snapshot.key +'">Delete</button>' +
		'<button class="btn-update-key"  data-key="' + snapshot.key +'" id="up'+snapshot.key+'">Update</button>' +
		'<span id="ok' + snapshot.key +'"></span>' +
		'</td>' +
		'');
});

dbRef.on('child_removed', function (snapshot) {
	$("#"+snapshot.key).remove();
});

$(document).ready(function () {
	$("#cmdNext").click(function () {
		lastKey = $("#datafirebase tr:last-child").attr("id");
		firebase.database().ref('notifications/').limitToFirst(pageSize).startAt(null, lastKey).once("value").then(function(snapshot){
			cnt = 0;
			snapshot.forEach(function(child) {
				if(cnt > 0) {
					$('#datafirebase').append('<tr id="' + child.key + '" style="background-color:white">' +
						'<td id="from' + child.key + '">' + child.val().FromID + '</td>' +
						'<td id="to' + child.key + '">' + child.val().ToID + '</td>' +
						'<td><button class="btn-remove-key"  data-key="' + child.key + '">Delete</button>' +
						'<button class="btn-update-key"  data-key="' + child.key + '" id="up' + child.key + '">Update</button>' +
						'<span id="ok' + child.key + '"></span>' +
						'</td>' +
						'</tr>');
				}
				cnt++;
			});
		});
	});
	$("#addFirebase").click(function () {
		dbRef.push().set({
			notification_id: 11,
			to_type: 2,
			from_type: 1,
			to_id: 136,
			from_id: 1,
			message: 'Lodging Source has been added a job',
			link: '/job/705',
			is_read: 0

		});
	});

});
// var remove = function(e){

//     var key = $(this).data('key');

//     if(confirm('Are you sure?')){
//         dbRef.child(key).remove();
//     }
// }
// $(document).on('click', '.btn-remove-key', remove);

// var update = function(e){

//     var key = $(this).data('key');
//     $(this).hide();
//     fro = $('#from'+key);
//     fro.html('<input type="text" value="'+fro.text()+'"  id="froval'+key+'"/>');

//     toos = $('#to'+key);
//     toos.html('<input type="text" value="'+toos.text()+'" id="toval'+key+'"/>');

//     okss = $('#ok'+key);
//     okss.html('<input type="button" value="Submit" class="submitfirbase" data-key="'+key+'"/>');
// }

// $(document).on('click', '.btn-update-key', update);

// var submitform = function(e){
//     var key = $(this).data('key');
//     var fromval = parseInt($.trim($('#froval'+key).val()));
//     var toval = parseInt($.trim($('#toval'+key).val()));

//     firebase.database().ref('notifications/'+key+'/').set({
//         FromID: fromval,
//         ToID: toval
//     });

// }
// $(document).on('click', '.submitfirbase', submitform);
function snicker() {
	var x = document.getElementById("snackbar");
	x.className = "show";
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
