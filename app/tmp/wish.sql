            SELECT 
                W.*
                ,
                u_p.display_name
            FROM wish W
            LEFT JOIN user_profile AS u_p
                ON W.fulfilled_by = u_p.user_id
            WHERE 
                (
                    user_id = :selfID
                        OR 
                    user_id IN (   #Get friends id-s
                        SELECT 
                            CASE WHEN friend_id = :uid
                                THEN user_id
                                ELSE friend_id
                            END id
                        FROM friend
                        WHERE 
                                user_id     = :uid
                            OR
                                friend_id   = :uid
                    )
                )

                AND     #Include only wishes which :uid can see
            
                (W.user_id = :uid OR W.privacy = 2 
                    OR
                    (W.privacy = 9
                        AND
                           (SELECT 1 
                            FROM wish_access_list
                            WHERE wish_id = W.id AND user_id = :uid 
                            LIMIT 1)
                     )
                 )
                 
                 AND    # Also exclude inactive wishes
                    
                    ( 
                      W.expire IS NULL 
                        OR 
                      W.expire >= CURRENT_DATE() 
                     )
                    
            ORDER BY W.added DESC
