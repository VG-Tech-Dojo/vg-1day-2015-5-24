//
//  APIRequest.swift
//  My1DayApp
//
//  Created by 清 貴幸 on 2015/05/11.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import Foundation

class APIRequest: NSObject {
    static let baseURLString: String = "http://localhost:8888/"
    
    class func getMessages(completionHandler: ((NSData!, NSURLResponse!, NSError!) -> Void)?) {
        let URL : NSURL = NSURL(string: APIRequest.baseURLString + Endpoint.Messages.rawValue)!
        let request: NSURLRequest = NSURLRequest(URL: URL)
        let session: NSURLSession = NSURLSession.sharedSession()
        let task: NSURLSessionDataTask = session.dataTaskWithRequest(request, completionHandler: completionHandler)
        task.resume()
    }
    
    class func postMessage(message: String, username: String, completionHandler: ((NSData!, NSURLResponse!, NSError!) -> Void)?) {
        let request: NSMutableURLRequest = NSMutableURLRequest(URL: NSURL(string: APIRequest.baseURLString + Endpoint.Messages.rawValue)!)
        request.HTTPMethod = "POST"
        request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")

        var error: NSError?
        request.HTTPBody = NSJSONSerialization.dataWithJSONObject(["username":username, "body":message], options: NSJSONWritingOptions.allZeros, error: &error)
        
        if error != nil{
            println(error)
            return
        }
        
        let session: NSURLSession = NSURLSession.sharedSession()
        let task: NSURLSessionDataTask = session.dataTaskWithRequest(request, completionHandler: completionHandler)
        task.resume()
    }

    enum Endpoint: String {
        case Messages = "messages"
    }
}