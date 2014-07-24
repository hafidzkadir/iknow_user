	/*
	$(function() {
	  setTimeout(hideSplash, 300);
	});
	
	function hideSplash() {
	  $.mobile.changePage("#employeeListPage", "fade");
	}
	*/
	
	var employees;
	var activities;
	
	$('#employeeListPage')
		.bind('pageinit', function(event) {
			getEmployeeList();
		});
	
	$('#activityListPage')
		.bind('pageinit', function(event) {
			getActivityList();
		});
	
	$('#creditListPage')
		.bind('pageinit', function(event) {	
			$('.flexslider2').flexslider({
				  slideDirection: "vertical",
				  animation: "slide",
				  start: function(slider){
					$('.flexslider2').css("max-height" , "574px");
				}
			});
		});
	
	$('#currentListPage')
		.bind('pageinit', function(event) {
			getCurrentList();
		});
		
	function getEmployeeList() {
			$.getJSON('http://localhost/iknow_user/services/getemployees.php', function(data) {
				$('#employeeList li').remove();
				employees = data.items;
				$.each(employees, function(index, employee) {
					
					var report;
					
					if(employee.reportCount > 0 ){
						report = '<span class="ui-li-count">' + employee.reportCount + '</span></a></li>';
					} else { report = '';}
					
					$('#employeeList').append('<li><a href="employeedetails.html?nokp=' + employee.nokp + '" data-transition="flip">' +
							'<img src="images/staff/' + employee.fail_gambar + '"/>' +
							'<h4>' + employee.nama + '</h4>' +
							'<p>' + employee.jawatan + '</p>' + report);
				});
				$('#employeeList').listview('refresh');
			});
		//});
	}
	
	function getActivityList() {
		$.getJSON('http://localhost/iknow_user/services/getactivity.php', function(data) {
			$('#activityList li').remove();
			activities = data.items;
			$.each(activities, function(index, activity) {
				$('#activityList').append('<li><a href="activitylist.html?kod=' + activity.kod + '" data-transition="flip">' +
						'<h4>' + activity.perihal + '</h4>' +
						'<span class="ui-li-count">' + activity.jumlah + '</span></a></li>');
			});
			$('#activityList').listview('refresh');
		});
	}
	
	function getCurrentList() {
		$.getJSON('http://localhost/iknow_user/services/getmoto.php', function(data) {
			$('#motoList li').remove();
			var motos = data.item;
			$.each(motos, function(index, moto) {
				if(moto.jumlah > 0) {
					$('#motoList').append('<li>'+
					'<h4 align="center">Pernyataan Positif</h4><hr/>'+
					'<h3 align="center">"'+ moto.ayat + '"</h3>'+
					'<h4 align="center">Oleh: '+ moto.nama + '</h4></li>');
				}		
			});
			$('#motoList').listview('refresh');
		});
		
		$.getJSON('http://localhost/iknow_user/services/getcurrent.php', function(data) {
			$('#currentList li').remove();
			var currents = data.items;
			$.each(currents, function(index, current) {
				tarikh_semasa = ubah_tarikh(current.mula, current.tamat);
				$('#currentWeek').text(tarikh_semasa);
				$('#currentDays').text('(Isnin Hingga Jumaat)');
				$('#currentList').append('<li><a href="activitydetails.html?id=' + current.id + '" data-transition="flip"><h4>' + current.nama + '</h4></a></li>');
			});
			$('#currentList').listview('refresh');
		});
		
		$.getJSON('http://localhost/iknow_user/services/getworker.php', function(data) {
			$('#workerList li').remove();
			var workers = data.item;
			$.each(workers, function(index, worker) {
				if(worker.jumlah > 0) {
					$('#workerList').append('<li><a href="workerlist.html" data-transition="flip"><h4>Pegawai Contoh</h4>'+
					'<span class="ui-li-count">' + worker.jumlah + '</span></a></li>');
				}		
			});
			$('#workerList').listview('refresh');
		});	
		
		$.getJSON('http://localhost/iknow_user/services/getcounter.php', function(data) {
			$('#counterList li').remove();
			var counters = data.item;
			$.each(counters, function(index, counter) {
				
				if(counter.jumlah > 0) {
					$('#counterList').append('<li><a href="counterlist.html" data-transition="flip"><h4>Petugas Kaunter</h4>'+
							'<span class="ui-li-count">' + counter.jumlah + '</span></a></li>');
				}		
			});
			$('#counterList').listview('refresh');
		});	
		
		$.getJSON('http://localhost/iknow_user/services/getbirthday.php', function(data) {
			$('#birthdayList li').remove();
			var birthdays = data.item;
			$.each(birthdays, function(index, birthday) {
				
				if(birthday.jumlah > 0) {
					$('#birthdayList').append('<li><a href="birthdaylist.html" data-transition="flip">' +
							'<h4>Harijadi Pegawai</h4>' +
							'<span class="ui-li-count">' + birthday.jumlah + '</span></a></li>');
				}		
			});
			$('#birthdayList').listview('refresh');
		});	
	}
	
	function ubah_tarikh(mula,tamat){
		tahun 	= mula.substr(0, 4);
		bulan 	= mula.substr(5, 2);
		harim 	= mula.substr(8, 2);
		harit 	= tamat.substr(8, 2);
		
		bulan = ubah_bulan(bulan);

		tarikh_ubah = harim+' hingga '+harit+' '+bulan+' '+tahun;
		
		return tarikh_ubah;
	}
	
	function ubah_bulan(bulan){
		switch(bulan){
			case '01': bulan='Januari'; break;
			case '02': bulan='Februari'; break;
			case '03': bulan='Mac'; break;
			case '04': bulan='April'; break;
			case '05': bulan='Mei'; break;
			case '06': bulan='Jun'; break;
			case '07': bulan='Julai'; break;
			case '08': bulan='Ogos'; break;
			case '09': bulan='September'; break;
			case '10': bulan='Oktober'; break;
			case '11': bulan='November'; break;
			case '12': bulan='Disember'; break;
		}
		
		return bulan;
	}
	
	function ubah_hari(tahun,bulan,hari){
		
		var d = new Date(tahun+'-'+bulan+'-'+hari);
		var hari = d.getDay();
		
		switch(hari){
			case 0: hari='Ahad'; break;
			case 1: hari='Isnin'; break;
			case 2: hari='Selasa'; break;
			case 3: hari='Rabu'; break;
			case 4: hari='Khamis'; break;
			case 5: hari='Jumaat'; break;
			case 6: hari='Sabtu'; break;
		}
		
		return hari;
	}
	
	$('#detailsPage').live('pageshow', function(event) {
		var nokp = getUrlVars()["nokp"];
		$.getJSON('http://localhost/iknow_user/services/getemployee.php?nokp='+nokp, displayEmployee);
	});
	
	$('#descriptionsPage').live('pageshow', function(event) {
		var nokp = getUrlVars()["nokp"];
		$.getJSON('http://localhost/iknow_user/services/getemployee.php?nokp='+nokp, displayEmployee);
	});
	
	function displayEmployee(data) {
		var employee = data.item;
		console.log(employee);
		
		$('#employeePic').attr('src', 'images/staff/' + employee.fail_gambar);
		$('#fullName').text(employee.nama);
		$('#employeeTitle').text(employee.jawatan);
		$('#city').text(employee.sektor);
		$('#title').text(employee.gelaran);
		$('#task').text(employee.tugas);
		$('#education').text(employee.kelayakan);
		
		console.log(employee.telefon_rasmi);
		
		if (employee.emel) {
			$('#actionList').append('<li><a href="mailto:' + employee.emel + '"><h3>Alamat Emel</h3>' +
					'<p>' + employee.emel + '</p></a></li>');
		}
		if (employee.telefon_rasmi) {
			$('#actionList').append('<li><a href="tel:' + employee.telefon_rasmi + '"><h3>Telefon Pejabat</h3>' +
					'<p>' + employee.telefon_rasmi + '</p></a></li>');
		}
		if (employee.telefon_bimbit) {
			$('#actionList').append('<li><a href="tel:' + employee.telefon_bimbit + '"><h3>Telefon Bimbit</h3>' +
					'<p>' + employee.telefon_bimbit + '</p></a></li>');
			$('#actionList').append('<li><a href="sms:' + employee.telefon_bimbit + '"><h3>SMS</h3>' +
					'<p>' + employee.telefon_bimbit + '</p></a></li>');
		}
		if (employee.tugas || employee.kelayakan) {
			$('#actionList').append('<li><a href="descriptiondetails.html?nokp=' + employee.nokp + '" data-transition="flip"><h3>Diskripsi</h3></a></li>');
		}
		if (employee.penyelia>0) {
			$('#actionList').append('<li><a href="employeedetails.html?nokp=' + employee.penyelia + '" data-transition="flip"><h3>Penyelia</h3>' +
					'<p>' + employee.nama_penyelia + '</p></a></li>');
		}
		if (employee.reportCount>0) {
			$('#actionList').append('<li><a href="reportlist.html?nokp=' + employee.nokp + '" data-transition="flip"><h3>Penolong</h3>' +
					'<p>' + employee.reportCount + ' orang</p></a></li>');
		}
		$('#actionList').listview('refresh');
	}
	
	$('#activityPage').live('pageshow', function(event) {
		var id = getUrlVars()["id"];
		$.getJSON('http://localhost/iknow_user/services/getactivity2.php?id='+id, displayActivity);
	});
	
	function displayActivity(data) {
		var activity = data.item;
		console.log(activity);
		$('#name').text(activity.nama);
		$('#place').text(activity.tempat);
		$('#date').text(activity.tarikh);
		$('#time').text(activity.masa);
	}
	
	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++){
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
	
	$('#reportListPage').live('pageshow', function(event) {
		var nokp = getUrlVars()["nokp"];
		console.log("reports for " + nokp);
		$.getJSON('http://localhost/iknow_user/services/getreports.php?nokp='+nokp, function (data) {
			var reports = data.items;
			$.each(reports, function(index, employee) {
				$('#reportList').append('<li><a href="employeedetails.html?nokp=' + employee.nokp + '" data-transition="flip">' +
						'<h4>' + employee.nama + '</h4>' +
						'<p>' + employee.jawatan + '</p>' +
						'<span class="ui-li-count">' + employee.reportCount + '</span></a></li>');
			});
			$('#reportList').listview('refresh');
		});
	});
	
	
	$('#activity2ListPage').live('pageshow', function(event) {
		
		var kod = getUrlVars()["kod"];
		console.log("activities for " + kod);
		
		$.getJSON('http://localhost/iknow_user/services/getactivities.php?kod='+kod, function (data) {
			var activities = data.items;
			$.each(activities, function(index, activity) {
				$('#activity2List').append('<li><a href="activitydetails.html?id=' + activity.id + '" data-transition="flip">' +
					'<h4>' + activity.nama + '</h4></a></li>');
			});
			$('#activity2List').listview('refresh');
		});
	});
	
	$('#workerListPage').live('pageshow', function(event) {
		
		$.getJSON('http://localhost/iknow_user/services/getworker2.php', function (data) {
			var workers = data.item;
			$.each(workers, function(index, worker) {
				$('#bulan').text(ubah_bulan(worker.bulan));
				$('#tahun').text(worker.tahun);
				
				$('#worker2List')
					.append(
					'<li><a href="employeedetails.html?nokp=' + worker.nokp + '" data-transition="flip">'+
					'<div align="center"><img src="images/staff/' + worker.fail_gambar + '"/></div>' +
					'<h4 align="center">' + worker.nama + '</h4>' + 
					'<h5 align="center">' + worker.kumpulan + '</h5>' + 
					'</a></li>'
					);
			});
			$('#worker2List').listview('refresh');
		});
	});
	
	$('#counterListPage').live('pageshow', function(event) {
		
		$.getJSON('http://localhost/iknow_user/services/getcounter2.php', function (data) {
			var counters = data.item;
			$.each(counters, function(index, counter) {
				$('#nama_hari').text(ubah_hari(counter.tahun,counter.bulan,counter.hari));
				$('#hari').text(counter.hari);
				$('#bulan').text(ubah_bulan(counter.bulan));
				$('#tahun').text(counter.tahun);
				
				$('#counter2List')
					.append(
					'<li><a href="employeedetails.html?nokp=' + counter.nokp + '" data-transition="flip">'+
					'<div align="center"><img src="images/staff/' + counter.fail_gambar + '"/></div>' +
					'<h4 align="center">' + counter.nama + '</h4>' + 
					'</a></li>');
			});
			$('#counter2List').listview('refresh');
		});
	});
	
	$('#birthdayListPage').live('pageshow', function(event) {
		
		$.getJSON('http://localhost/iknow_user/services/getbirthday2.php', function (data) {
			var birthdays = data.item;
			$.each(birthdays, function(index, birthday) {
				$('#bulan').text(ubah_bulan(birthday.bulan));
				$('#tahun').text(birthday.tahun);
				
				$('#birthday2List')
					.append(
					'<li>'+
					'<div align="center"><img src="images/staff/' + birthday.fail_gambar + '"/></div>' +
					'<h4 align="center">' + birthday.nama + '</h4>' + 
					'<h5 align="center">Ulangtahun kelahiran ke-' + birthday.umur + '</h5>' + 
					'<h5 align="center">' + birthday.hari +' '+ubah_bulan(birthday.bulan)+' '+birthday.tahun+' ('+ubah_hari(birthday.tahun,birthday.bulan,birthday.hari)+ ')</h5>' + 
					'</li>'
					);
			});
			$('#birthday2List').listview('refresh');
		});
	});