<!DOCTYPE html>
<html>
    <head>
        <title>Add student</title>
        <link rel="stylesheet" type="text/css" href="CSS/add.css">
        <link rel="stylesheet" type="text/css" href="CSS/addvisitegen.css">
        
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>
    <body>
    <?php include "header.php"; ?>
        <div class="page-container">
            
            <p class="add_student">Medical Exam</p>
               
            
            <hr>
            <form action="">
                <div class="section1">
                    <h2>Examen Medical De Depistage</h2>
                    <label>Student Info:</label>
                    <div class="name_parent">
                        <input class="name1" type="text" placeholder="Age" required>
                        <input class="name" type="text" placeholder="Height" max="3" required>
                        <input class="name2" type="text" placeholder="Weight" max="3" required>
                    </div>
                    <label>Date of Exam:</label>
                    <div class="va-header">
                        <input class="text" type="date" >
                    </div>
                    <label>Tension Arteriellle:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    <label>Eye info:</label>
                    <div class="name_parent">
                        <input class="name1" type="text" placeholder="Acuite OD" max="2" required>
                        <input class="name2" type="text" placeholder="Visuelle OG" max="2" required>
                    </div>
                    <label>Adress:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    <div class="va-header">
                        <button type="submit">Add</button>
                    </div>
                </div>
                <div class="section2">
                    
                    <h2>Antecedents De L'eleve</h2>

                    
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="hospitalisation" name="hospitalisation" type="checkbox"/>
                        <label class="cbx" for="hospitalisation"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Hospitalisation</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                      </div>
                    <div class="name_parent" id="id_1" style="display:none;">
                        
                        <input class="name1 popup" type="text" placeholder="cause" required>
                        <input class="name2" type="date" placeholder="date" required>
                    </div>
                   
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="epilepsie" name="epilepsie" type="checkbox"/>
                        <label class="cbx" for="epilepsie"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Epilepsie</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                    </div>
                    <div class="name_parent" id="id_2" style="display:none;">
                        <input class="popup"  type="text" placeholder="frequences des crises" required>
                    </div>

                    
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="asthme" name="asthme" type="checkbox"/>
                        <label class="cbx" for="asthme"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Asthme</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                    </div>
                    
                    <div class="name_parent" id="id_3" style="display:none;">
                        <input class="popup"   type="text" placeholder="frequences des crises" required>
                    </div>
                    
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="diabete" name="diabete" type="checkbox"/>
                        <label class="cbx" for="diabete"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Diabete</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                      </div>
                    <div class="name_parent" id="id_4" style="display:none;">
                        <input class="popup"  type="date" placeholder="date de debut" required>
                        
                    </div>
                </div>
                <div class="section3">
                    <h2>Examen Medical</h2>
                    <div class="checkbox-container">
                        <div class="column">
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="neurologique" name="neurologique" type="checkbox"/>
                                <label class="cbx" for="neurologique"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Neurologique</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="endocrinien" name="endocrinien" type="checkbox"/>
                                <label class="cbx" for="endocrinien"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Endocrinien</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="rachis" name="rachis" type="checkbox"/>
                                <label class="cbx" for="rachis"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>Rachis et Membres</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="pau" name="pau" type="checkbox"/>
                                <label class="cbx" for="pau"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>Pau et Phaneres</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="ophtalmique" name="ophtalmique" type="checkbox"/>
                                <label class="cbx" for="ophtalmique"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Ophtalmique</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="orl" name="orl" type="checkbox"/>
                                <label class="cbx" for="orl"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App ORL</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                        </div>
                        <div class="column">
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="respiratoire" name="respiratoire" type="checkbox"/>
                                <label class="cbx" for="respiratoire"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Respiratoire</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="cardio" name="cardio" type="checkbox"/>
                                <label class="cbx" for="cardio"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Cardio-vasculaire</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="digestif" name="digestif" type="checkbox"/>
                                <label class="cbx" for="digestif"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Digestif</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>

                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="urinaire" name="urinaire" type="checkbox"/>
                                <label class="cbx" for="urinaire"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Urinaire</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                            
                            <div class="checkbox-wrapper-4">
                                <input class="inp-cbx" id="genital" name="genital" type="checkbox"/>
                                <label class="cbx" for="genital"><span>
                                <svg width="12px" height="10px">
                                  <use xlink:href="#check-4"></use>
                                </svg></span><span>App Genital</span></label>
                                <svg class="inline-svg">
                                  <symbol id="check-4" viewbox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                  </symbol>
                                </svg>
                              </div>
                        </div>
                    
                      </div>
                </div>
            </form>
        </div>
        <style>
          body{
            min-width: 700px;
          }
.test{
    display: flex;
}
.section1{
    width: 33%;
    height: 100%;
    display: inline-block;
    float: left;
}
.section2{
    width: 25%;
    float: none;
    height: 100%;
    display: inline-block;
}
.section3{
    width: 42%;
    float: right;
    height: 100%;
    display: inline-block;
}
.column {
    float: left;
    width: 50%;
}
.name{
    width: 15%;
    margin-left: 0;
    margin-right: 0;
    outline: 0;
    border-radius:0 0 0 0;
}
.name1{
    width: 15%;
    margin-right: 0;
    outline: 0;
    border-radius: 6px 0 0 6px ;
}
.name2{
    width: 15%;
    margin-left: 0;
    margin-right: 0;
    outline: 0;
    border-radius:0 6px 6px 0;
}

        </style>
        
       <script>
        const checkbox1 = document.getElementsByName('hospitalisation')[0];
        const inputContainer1 = document.getElementById('id_1');
      
        const checkbox2 = document.getElementsByName('epilepsie')[0];
        const inputContainer2 = document.getElementById('id_2');
      
        const checkbox3 = document.getElementsByName('asthme')[0];
        const inputContainer3 = document.getElementById('id_3');

        const checkbox4 = document.getElementsByName('diabete')[0];
        const inputContainer4 = document.getElementById('id_4');
      
        checkbox1.addEventListener('click', () => {
          if (checkbox1.checked) {
            inputContainer1.style.display = 'block';
          } else {
            inputContainer1.style.display = 'none';
          }
        });
      
        checkbox2.addEventListener('click', () => {
          if (checkbox2.checked) {
            inputContainer2.style.display = 'block';
          } else {
            inputContainer2.style.display = 'none';
          }
        });
      
        checkbox3.addEventListener('click', () => {
          if (checkbox3.checked) {
            inputContainer3.style.display = 'block';
          } else {
            inputContainer3.style.display = 'none';
          }
        });
        checkbox4.addEventListener('click', () => {
          if (checkbox4.checked) {
            inputContainer4.style.display = 'block';
          } else {
            inputContainer4.style.display = 'none';
          }
        });
      </script>
      
        <script type="text/javascript" src="Scripts/index.js"></script>
    </body>
</html>