<!DOCTYPE html>
<html>
    <head>
        <title>add visite dentaire</title>
        <link rel="stylesheet" type="text/css" href="CSS/addvisitedentair.css">
        <link rel="stylesheet" type="text/css" href="CSS/add.css">
        
        
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>
    <body>

    <?php include "header.php"; ?>
        <div class="page-container">
            <p class="add_student">Fiche de Sante Dentaire</p>
            <hr>
            <form action="" method="">
                
                <div class="input-container">
                  <label>Date:</label>
                  <input  type="date" name="date" >
    
                </div>
                <div class="input-container">
                   <label>class:</label>
                   <input type="text" name="class">
                </div>
                
                
                
                <label>Hygiene Bucco-dentaire:</label>
                <div class="va-header">
                    <select name="hygiene" class="select">
                        <option selected disabled>Select one</option>
                        <option value="1">Acceptable</option>
                        <option value="2">Non Acceptable</option>
                    </select>
                </div>
                <label>Gingivite:</label>
                    
                <div class="check-container">
                    
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="localisee" name="localisee" type="checkbox"/>
                        <label class="cbx" for="localisee"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Localisee</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                    </div>
                    
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="generalisee" name="generalisee" type="checkbox"/>
                        <label class="cbx" for="generalisee"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Generalisee</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                    </div>
                    
                    <div class="checkbox-wrapper-4">
                        <input class="inp-cbx" id="tartre" name="tartre" type="checkbox"/>
                        <label class="cbx" for="tartre"><span>
                        <svg width="12px" height="10px">
                          <use xlink:href="#check-4"></use>
                        </svg></span><span>Tartre</span></label>
                        <svg class="inline-svg">
                          <symbol id="check-4" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                          </symbol>
                        </svg>
                    </div>
                </div>
                <label>Anomalie Dento-Faciale</label>
                <div>
                    <input type="text" name="anomalie">
                </div>
                <div class="va-header">
                    <button type="submit" name="submit">Add</button>
                </div>
            </form>
        </div>
        <style>
       
          input{
  width:15%;
}
button{
  width:15%;
}
h2{
    margin-left: 100px;
}


        </style>

        <script type="text/javascript" src="Scripts/index.js"></script>
    </body>
</html>