//
//  Message.swift
//  My1DayApp
//
//  Created by 清 貴幸 on 2015/05/15.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import UIKit

class Message {
    let body: String!
    let icon: UIImage?
    let created_at: String?
    // Mission1-1. created_at 用のインスタンス変数を追加
    
    init?(dictionary: [String: AnyObject]) {
        // Mission1-1 Dictionary から key:created_at の値を取得
        
        if let body: String = dictionary["body"] as? String, let icon: String = dictionary["icon"] as? String,
            let created_at: String = dictionary["created_at"] as? String{
            self.body = body
            self.icon = ImageHelper.imageWithBase64EncodedString(icon)
            self.created_at = created_at
            // Mission1-1 Dictionary から取得した値を created_at 用のインスタンス変数に追加
        } else {
            self.body = nil
            self.icon = nil
            self.created_at = nil
            // Mission1-1 インスタンス変数を nil で初期化
            return nil
        }
    }
}
