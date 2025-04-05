<?php 
    include('file.php');
    date_default_timezone_set('Asia/Manila');


    if(isset($_POST['getCarousel'])){
        $idCarousel = $_POST['getCarousel'];
        $dataArr = array();
        $sql = "SELECT * FROM home_carousel WHERE IdCarousel =:idCarousel";
        $query = $conn->prepare($sql);
        $query->bindParam(':idCarousel',$idCarousel,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($result) > 0){
            foreach($result as $data){
                array_push($dataArr,$data['CarouselTitle'],$data['CarouselImg'],$data['CarouselStatus']);
            } 
        }
        echo json_encode($dataArr);

    }
    if(isset($_POST['getArticle'])){
        $idArticle = $_POST['getArticle'];
        $dataArr = array();
        $sql = "SELECT * FROM articles WHERE IdArticle =:idArticle";
        $query = $conn->prepare($sql);
        $query->bindParam(':idArticle',$idArticle,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($result) > 0){
            foreach($result as $data){
                array_push($dataArr,$data['ArticleTitle'],$data['ArticleFigure'],$data['ArticleDescription'],$data['ArticleStatus']);
            } 
        }
        echo json_encode($dataArr);

    }

    if(isset($_POST['getArticleImage'])){
        $idArticle = $_POST['getArticleImage'];

        $sql = "SELECT * FROM article_images WHERE ArticleId =:idArticle";
        $query = $conn->prepare($sql);
        $query->bindParam(':idArticle',$idArticle,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($result) > 0){
            foreach($result as $data){
                if($data['IsMainImage'] == 0){
                    echo '
                    <div class="col-4 text-center">
                        <img src="../assets/uploads/article/'.$data['ArticleImage'].'" style="width:200px;">
                        <button class="btn btn-primary mt-2" onclick="selectMain('.$data['IdArticleImg'].','.$data['ArticleId'].')">Select</button>
                    </div>
              '; 
                }else{
                    echo '
                    <div class="col-4 text-center">
                        <img src="../assets/uploads/article/'.$data['ArticleImage'].'" style="width:200px;">
                         <button class="btn btn-primary mt-2" disabled>Main Image</button>
                    </div>
              ';
                }
            } 
        }

    }

    if(isset($_POST['selectMain'])){
        $idArticleImg = $_POST['selectMain'];
        $articleId = $_POST['articleId'];

        $sql = "UPDATE article_images SET IsMainImage= 0 WHERE ArticleId =:articleId";
        $query = $conn->prepare($sql);
        $query->bindParam(':articleId',$articleId,PDO::PARAM_INT);
        if($query->execute()){
            $sql1 = "UPDATE article_images SET IsMainImage= 1 WHERE IdArticleImg=:idArticleImg";
            $query1 = $conn->prepare($sql1);
            $query1->bindParam(':idArticleImg',$idArticleImg,PDO::PARAM_INT);
            if($query1->execute()){
                echo 0;
            }else{
                echo 1;
            }
        }


    }
?>