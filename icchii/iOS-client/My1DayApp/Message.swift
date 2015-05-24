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
    // Mission1-1. created_at 用のインスタンス変数を追加
    let date: String!
    let userName: String!
    init?(dictionary: [String: AnyObject]) {
        // Mission1-1 Dictionary から key:created_at の値を取得
        if let body: String = dictionary["body"] as? String, let icon: String = dictionary["icon"] as? String, let date: String = dictionary["created_at"] as? String, let userName: String = dictionary["username"] as? String{
            self.body = body
            self.icon = ImageHelper.imageWithBase64EncodedString(icon)
            // Mission1-1 Dictionary から取得した値を created_at 用のインスタンス変数に追加
            self.date = date
            self.userName = userName
        } else {
            self.body = nil
            self.icon = nil
            // Mission1-1 インスタンス変数を nil で初期化
            self.date = nil
            self.userName = nil
            return nil
        }
    }
}
