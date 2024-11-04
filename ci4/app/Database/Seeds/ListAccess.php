<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ListAccess extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `list_access` (`id`, `page`) VALUES
      (1,'administrator'),
      (2,'client')
      ");
        $this->db->query("INSERT INTO `user` (`id`,  `nama_depan`,  `nama_belakang`,  `password`,  `email`, `profile_picture`,  `level`,  `status`,  `updated_at`,  `deleted_at`,  `created_at`) VALUES
      (1,'Suluh','Arwani','','suluharwani007@gmail.com','https://lh3.googleusercontent.com/a/AEdFTp6N5mXIFVr46yJYYt7H97EGO3Zt9nFc_23gyavOsg=s96-c','1','1','2023-01-16 21:41:03',NULL,'2023-01-16 21:41:03')
      ");

        $this->db->query("INSERT INTO `static_page` (`id`, `page`,`slug`,`status`) VALUES
      (1,'Contact Us','contact-us',1),
      (2,'Slider','slider',1),
      (3,'Service','service',1),
      (4,'Portfolio','portfolio',1),
      (5,'Testimonial','testimonial',1),
      (6,'Partner','partner',1),
      (7,'Offer','offer',1)
      ");
    }
}

