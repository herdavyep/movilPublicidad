<?php
/**
 * The template for displaying about layout.
 *
 * @package wpparallax
 */
?>

<div class="contenedorGrande">
	<?php  
        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
	      $section_title = get_the_title();
          if($show_title == 'on'){
          wp_parallax_section_title($section_title);
          }
	      ?>
        <div class="default-content">
        	<?php the_content();?>
        </div>
        <?php
        endwhile; 
        wp_reset_postdata();
    ?>	
	
 <style>     
	 
	 
		 .contenedorGrande{
			   position:relative;
			 	width:100%;
            }
			 #paraDescargar{
				 position: relative;  
				 height:210px;
			}
			
            .sobre {
                width:100%;
                height:auto;
                position:absolute;
                top:5%;
                left:50%;
                transform:translateX(-50%);
                z-index:40;
                border:none;
            }
            .contForm{
                position: relative;
				width:50%;
                bottom:-18%;
                left:66%;
                transform:translateX(-50%);
            }
			
            .debajo{
                    
            
            }
            .sobre2{
                position:absolute;
                top:31.5%;
                left:42%;
				transform:translateX(-50%);
                z-index:10;          
                width:35%;
                height:auto;
            }
            .imagenDebajo{
				position:absolute;
				top:31.5%;
				left:42%;
				transform:translateX(-50%);
				z-index:30; 
                width:35%;
                height:auto;
            }
	 
	  		
    		.file-input {
        visibility: hidden;
        width: 0;
        position: relative;
        }
        .labelArchivo {
		padding: 3.5px 8px;
        content: 'CARGAR IMAGEN';
        display: inline-block;
        background: rgb(255 255 255);
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        color:rgb(58 153 215);
        font-weight: 700;
        font-size: 10pt;
        visibility: visible;
        position: absolute;
		left:23.5%;
        transform:translateX(-50%);
        }
       
			 #save{
				color:rgb(58 153 215);
				background: rgb(255 255 255);
				padding: 3.5px 8px;
				font-weight: 700;
				font-size: 10pt;
				 margin-left:-21%;
			 }
     
	 
	 
	 
	 		@media (min-width:600px){
            .contenedorGrande{
            height:600px;

			}
			#paraDescargar{
			height:600px;
			}
		   .sobre {
			width:100%;
			height:auto;
			position:absolute;
			top:30px;
			left:50%;
			transform:translateX(-50%);
			z-index:40;
			border:none;
			}
			 .sobre2{
				position:absolute;
				top:20%;
				left:40.5%;
				z-index:10;          
				width:35%;
				height:auto;
			}
			.imagenDebajo{
				position:absolute;
				top:20%;
				left:40.5%;
				z-index:30; 
				width:35%;
				height:auto;
			}

			.contForm{
				position: absolute;
				bottom:0%;
				left:65%;
				transform:translateX(-50%);

			}
				#save{
					margin-left:4%;
				}
        }
	 @media (min-width:1024px){
	 .contenedorGrande{
		 position:relative;
           height:500px;

			}
			#paraDescargar{
			height:500px;
			}
		  .sobre {
			width:60%;
			height:auto;
			position:absolute;
			top:30px;
			left:50%;
			transform:translateX(-50%);
			z-index:40;
			border:none;
			}
			 .sobre2{
				position:absolute;
				top:142px;
				left:45%;
				transform:translateX(-50%);
				z-index:10;          
				width:233px;
				height:159px;
			}
			.imagenDebajo{
				position:absolute;
				top:142px;
				left:45%;
				transform:translateX(-50%);
				z-index:30;    
				width:233px;
				height:159px;
			}

			.contForm{
				position: absolute;
				bottom:-8%;
				left:50%;
				transform:translateX(-50%);

			}
		 .labelArchivo {
			position:absolute;
			left:50%;
		 }
		 #save{
			position: relative;
    		left: 50%;
    		transform: translateX(-50%);
			margin-left:0%; 
		 }
	 }
		
    </style>
    <div class="" id="paraDescargar" >
        <img class="sobre "  src="data:image/png;base64,<?php echo base64_encode(file_get_contents("http://movilpublicidad.com/wp-content/uploads/2018/10/marco.png")) ?>" alt="">
        <img class="sobre2 "  src="http://movilpublicidad.com/wp-content/uploads/2018/10/SUBE-TU-IMAGEN.jpg" alt="">
		<div class="debajo" id="preview" >

        </div>
    </div>
    <div class="contForm">
        <form class="formulario" method="post" enctype="multipart/form-data">
            <label class="labelArchivo" for="subirArchivo">CARGAR IMAGEN</label>
			<input id="subirArchivo" type="file" onchange="preview(this)" class="file-input" />
        </form> 
         <button id="save"> GUARDAR IMAGEN</button>
       <!--<a id="btn-Convert-Html2Image" href="#" class="formulario">Descargar</a> -->
    </div>

    

<script>
	
 
// Funcion para previsualizar la imagen
function preview(e)
{
	if(e.files && e.files[0])
	{
 
		// Comprobamos que sea un formato de imagen
		if (e.files[0].type.match('image.*')) {
 
			// Inicializamos un FileReader. permite que las aplicaciones web lean 
			// ficheros (o información en buffer) almacenados en el cliente de forma
			// asíncrona
			// Mas info en: https://developer.mozilla.org/es/docs/Web/API/FileReader
			var reader=new FileReader();
 
			// El evento onload se ejecuta cada vez que se ha leido el archivo
			// correctamente
			reader.onload=function(e) {
				console.log(e.target.result);
				document.getElementById("preview").innerHTML="<img class='imagenDebajo' src='"+e.target.result+"' >";
			}
 
			// El evento onerror se ejecuta si ha encontrado un error de lectura
			reader.onerror=function(e) {
				document.getElementById("preview").innerHTML="Error de lectura";
			}
 
			// indicamos que lea la imagen seleccionado por el usuario de su disco duro
			reader.readAsDataURL(e.files[0]);
		}else{
 
			// El formato del archivo no es una imagen
			document.getElementById("preview").innerHTML="No es un formato de imagen";
		}
	}
}
</script>
<script src="jquery-3.3.1.js"></script>
<script src="html2canvas.min.js"></script>
<script src="canvas2image.js"></script>
<script>
	
    
    
       $('#save').click(function(){
           var elm = $('#paraDescargar').get(0);
           var lebar = 1440;
           var tinggi = 900;
           var type = "png";
           var filename = "movil_publicidad";
           html2canvas(elm).then(function(canvas){
                var canWidth = canvas.width;
                var canHeight = canvas.height;
                var img = Canvas2Image.convertToImage(canvas, canWidth, canHeight);
                //$('#preview').after(img);
                Canvas2Image.saveAsImage(canvas,lebar,tinggi,type,filename)
           })
       })
	
</script>
</div>















<?php
/**
 * The template for displaying all Parallax Templates.
 *
 * @package wpparallax
 */
?>


<?php
/*

	<div class="blog-section">
	   <div class="blogwrap clearfix">	
	<?php 

        $query = new WP_Query( 'page_id='.$page_id );
        while ( $query->have_posts() ) : $query->the_post();
	      $section_title = get_the_title();
	      if($show_title == 'on'){
	      wp_parallax_section_title($section_title);
	      }
        endwhile;
        wp_reset_postdata();
		$args = array(
			'cat' => $cat_id,
			'posts_per_page' => 3
			);
		$query = new WP_Query($args);
		if($query->have_posts()):
			$count_service = 1;
            while ($query->have_posts()): $query->the_post();	
            $image_path = wp_get_attachment_image_src( get_post_thumbnail_id(), 'wpparallax-blog-image', true );
		    ?>
		    	
	            <div class="blogsinfo wow fadeInUp clearfix" data-wow-duration="0.5s">
	                <?php if( has_post_thumbnail() ) { ?>
	                    <div class="blog-image">
	                        <figure>
	                            <a href="<?php the_permalink(); ?>">
	                                <img src="<?php echo esc_url( $image_path[0] ); ?>" alt="<?php the_title(); ?>" />
	                            </a>
	                        </figure>
	                    </div>
	                <?php   } ?>
	                <div class="blog-info clearfix">
	                    <h4>
	                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                    </h4>
	                    <ul>
	                        <li>
	                            <?php echo esc_html__('BY','wpparallax') ?>
	                            <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>">
	                               <span><?php the_author(); ?></span>
	                            </a>
	                        </li>
	                        <li>
	                            <?php the_category( ', '); ?>
	                        </li>
	                    </ul> 
	                </div>
	                <div class="blog-time">
	                    <span class="blog-day"><?php the_time( 'd' ); ?></span>
	                    <span class="blog-month"><?php the_time( 'M' ); ?></span>
	                </div>                                                          
	            </div>          
            
	            <?php
		    endwhile;
			wp_reset_postdata();
		endif;
	?>
	</div>
	<div class="clearfix btn-wrap wow fadeInUp">
	<a class="read-more" href="<?php echo esc_url(get_category_link($cat_id))?>"><?php echo esc_html__('View All','wpparallax'); ?></a>
	</div>  	
	</div>
	
	*/
?>